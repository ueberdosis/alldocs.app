<?php

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

abstract class Pandoc
{
    private static function formats()
    {
        return Yaml::parseFile(__DIR__.'/formats.yaml');
    }

    public static function inputFormats()
    {
        return collect(
            data_get(self::formats(), 'input', [])
        );
    }

    public static function inputFormatNames()
    {
        return self::inputFormats()->pluck('name');
    }

    public static function inputFormat($from)
    {
        return self::inputFormats()->where('name', $from)->first();
    }

    public static function outputFormats()
    {
        return collect(
            data_get(self::formats(), 'output', [])
        );
    }

    public static function outputFormatNames()
    {
        return self::outputFormats()->pluck('name');
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
                    return $outputFormat['name'] === $inputFormat['name'];
                })
                ->each(function ($outputFormat) use ($items, $inputFormat) {
                    $slug = "{$inputFormat['name']}-to-{$outputFormat['name']}";

                    $items->push(json_decode(json_encode([
                        'inputFormat' => $inputFormat,
                        'outputFormat' => $outputFormat,
                        'slug' => $slug,
                        'url' => action('ConvertController@landingPage', $slug),
                    ])));
                });
        });

        return $items;
    }

    public static function validInputFormat($from)
    {
        return self::inputFormatNames()->contains($from);
    }

    public static function invalidInputFormat($from)
    {
        return !self::validInputFormat($from);
    }

    public static function validOutputFormat($to)
    {
        return self::outputFormatNames()->contains($to);
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
