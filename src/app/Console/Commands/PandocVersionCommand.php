<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ueberdosis\Pandoc\Facades\Pandoc;

class PandocVersionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandoc:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the pandoc version.';

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
        $this->info(Pandoc::version());
    }
}
