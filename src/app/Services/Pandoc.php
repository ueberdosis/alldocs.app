<?php

namespace App\Services;

abstract class Pandoc
{
    public static function convert($file, $from, $to, $outputFile = null)
    {
        $inputFile = storage_path("app/public/{$file}");

        if (!$outputFile) {
            // TODO: This takes only part of the filename for filenames with multiple dots
            // e.g. test.file.with.dots.pdf => test.pdf
            $outputFilename = explode('.', $file)[0].'.'.$to;
            $outputFile = storage_path("app/public/{$outputFilename}");
        } else {
            $outputFile = storage_path("app/public/{$outputFile}");
        }

        // Example: pandoc test1.md -f markdown -t html -s -o test1.html
        $command = sprintf("pandoc %s -f %s -t %s -s -o %s", $inputFile, $from, $to, $outputFile);
        exec(escapeshellcmd($command), $cmdOutput);

        return $cmdOutput;
    }
}
