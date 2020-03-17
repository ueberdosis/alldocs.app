<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ueberdosis\Pandoc\Facades\Pandoc;

class PandocConvertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandoc:convert
                            {file : The input file which should be converted}
                            {from : The format of the input file }
                            {to : The desired output format}
                            {output : The output filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts a given file from one format to another.';

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
        $return = Pandoc::file($this->argument('file'))
            ->from($this->argument('from'))
            ->to($this->argument('to'))
            ->output($this->argument('output'))
            ->convert();

        $this->info($return);
    }
}
