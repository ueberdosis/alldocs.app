<?php

namespace App\Console\Commands;

use App\Conversion;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears files, which are older than two hours.';

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
        $conversions = Conversion::where('created_at', '<', Carbon::now()->subHours(2))->get();

        foreach ($conversions as $conversion) {
            Storage::delete([
                'public/' . $conversion->id,
                'public/' . $conversion->hashId,
            ]);
            $conversion->delete();
        }
    }
}
