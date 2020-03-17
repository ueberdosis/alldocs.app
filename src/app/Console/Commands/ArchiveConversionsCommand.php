<?php

namespace App\Console\Commands;

use App\Models\Conversion;
use Illuminate\Console\Command;

class ArchiveConversionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversions:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes files, which are older than 24 hours, archives conversions.';

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
        $conversions = Conversion::query()
            ->unarchived()
            ->where('created_at', '<', now()->subHours(12))
            ->get();

        $conversions->each->archive();
    }
}
