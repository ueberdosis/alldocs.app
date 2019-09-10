<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PandocCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandoc
                            {file : The input file which should be converted}
                            {from_format : The format of the input file }
                            {to_format : The desired output format}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts a given file from one format to another';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        $fromFormat = $this->argument('from_format');
        $toFormat = $this->argument('to_format');

        $inputFile = storage_path('app/public/') . $file;
        $outputFile = storage_path('app/public/') . explode('.', $file)[0] . '.' . $toFormat;

        // Example: pandoc test1.md -f markdown -t html -s -o test1.html
        $command = sprintf("pandoc %s -f %s -t %s -s -o %s", $inputFile, $fromFormat, $toFormat, $outputFile);
        exec(escapeshellcmd($command), $cmdOutput);

        dd($cmdOutput);
    }
}
