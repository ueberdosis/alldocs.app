<?php

namespace App\Console\Commands;

use App\Services\Pandoc;
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
        Pandoc::convert(
            $this->argument('file'),
            $this->argument('from_format'),
            $this->argument('to_format')
        );
    }
}
