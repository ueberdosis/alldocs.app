<?php

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

abstract class Pandoc
{
    private static function config()
    {
        return once(function () {
            return Yaml::parseFile(__DIR__.'/config.yaml');
        });
    }

    public static function inputFormats()
    {
        return collect(
            data_get(self::config(), 'input', [])
        );
    }

    public static function inputFormat($from)
    {
        return self::inputFormats()->where('name', $from)->first();
    }

    public static function outputFormats()
    {
        return collect(
            data_get(self::config(), 'output', [])
        );
    }

    public static function outputFormat($to)
    {
        return self::outputFormats()->where('name', $to)->first();
    }

    public static function conversions()
    {
        $items = collect();

        self::inputFormats()->each(function ($inputFormat) use ($items) {
            self::outputFormats()
                ->reject(function ($outputFormat) use ($inputFormat) {
                    return $outputFormat === $inputFormat;
                })
                ->each(function ($outputFormat) use ($items, $inputFormat) {
                    $inputFormat = self::find($inputFormat);
                    $outputFormat = self::find($outputFormat);

                    $items->push(json_decode(json_encode([
                        'inputFormat' => $inputFormat,
                        'outputFormat' => $outputFormat,
                        'url' => action('ConvertController@landingPage', [
                            'input' => $inputFormat['slug'],
                            'output' => $outputFormat['slug'],
                        ]),
                    ])));
                });
        });

        return $items;
    }

    public static function find($id)
    {
        $item = collect(self::config()['details'])->first(function ($item) use ($id) {
            return data_get($item, 'slug') === $id || data_get($item, 'name') === $id;
        });

        if ($item) {
            $item['slug'] = $item['slug'] ?? $item['name'];
            $item['url'] = action('FormatController@show', $item['slug']);
        }

        return $item;
    }

    public static function validInputFormat($from)
    {
        $format = self::find($from);

        return $format && self::inputFormats()->contains($format['name']);
    }

    public static function invalidInputFormat($from)
    {
        return !self::validInputFormat($from);
    }

    public static function validOutputFormat($to)
    {
        $format = self::find($to);

        return $format && self::outputFormats()->contains($format['name']);
    }

    public static function invalidOutputFormat($to)
    {
        return !self::validOutputFormat($to);
    }

    public static function validConversion($from, $to)
    {
        return self::validInputFormat($from) && self::validOutputFormat($to);
    }

    public static function invalidConversion($from, $to)
    {
        return !self::validConversion($from, $to);
    }

    public static function convert($file, $from, $to, $outputFile = null)
    {
        $inputFile = storage_path('app/public/').$file;

        if (!$outputFile) {
            $outputFile = storage_path('app/public/').explode('.', $file)[0].'.'.$to;
        } else {
            $outputFile = storage_path('app/public/').$outputFile;
        }

        // Example: pandoc test1.md -f markdown -t html -s -o test1.html
        $command = sprintf("pandoc %s -f %s -t %s -s -o %s", $inputFile, $from, $to, $outputFile);
        exec(escapeshellcmd($command), $cmdOutput);
        return $cmdOutput;
    }
}
