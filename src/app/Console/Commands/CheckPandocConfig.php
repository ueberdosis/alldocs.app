<?php

namespace App\Console\Commands;

use App\Services\Pandoc;
use Illuminate\Console\Command;

class CheckPandocConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandoc:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Pandoc configuration';

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
        $formats = collect(data_get(Pandoc::config(), 'details'));

        $formatsTotal = $formats->count();
        $formatsTotalStatus = $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsTotalStatus} Found {$formatsTotal} formats.");

        $formatsWithTitle = $formats->whereNotNull('title')->count();
        $formatsWithTitlePercentage = number_format(100/$formatsTotal * $formatsWithTitle, 1);
        $formatsWithTitleStatus = $formatsWithTitle === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithTitleStatus} {$formatsWithTitlePercentage} % ({$formatsWithTitle}/{$formatsTotal}) have a title.");

        $formatsWithLongTitle = $formats->whereNotNull('long_title')->count();
        $formatsWithLongTitlePercentage = number_format(100/$formatsTotal * $formatsWithLongTitle, 1);
        $formatsWithLongTitleStatus = $formatsWithLongTitle === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithLongTitleStatus} {$formatsWithLongTitlePercentage} % ({$formatsWithLongTitle}/{$formatsTotal}) have a long title.");

        $formatsWithDescription = $formats->whereNotNull('description')->count();
        $formatsWithDescriptionPercentage = number_format(100/$formatsTotal * $formatsWithDescription, 1);
        $formatsWithDescriptionStatus = $formatsWithDescription === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithDescriptionStatus} {$formatsWithDescriptionPercentage} % ({$formatsWithDescription}/{$formatsTotal}) have a description.");

        $formatsWithDefaultExtension = $formats->whereNotNull('default_extension')->count();
        $formatsWithDefaultExtensionPercentage = number_format(100/$formatsTotal * $formatsWithDefaultExtension, 1);
        $formatsWithDefaultExtensionStatus = $formatsWithDefaultExtension === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithDefaultExtensionStatus} {$formatsWithDefaultExtensionPercentage} % ({$formatsWithDefaultExtension}/{$formatsTotal}) have a default extension.");

        $formatsWithExtensions = $formats->whereNotNull('extensions')->count();
        $formatsWithExtensionsPercentage = number_format(100/$formatsTotal * $formatsWithExtensions, 1);
        $formatsWithExtensionsStatus = $formatsWithExtensions === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithExtensionsStatus} {$formatsWithExtensionsPercentage} % ({$formatsWithExtensions}/{$formatsTotal}) have allowed extensions.");
    }
}
