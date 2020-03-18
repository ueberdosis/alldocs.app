<?php

namespace App\Console\Commands;

use App\Services\FileFormat;
use Illuminate\Console\Command;
use Ueberdosis\Pandoc\Facades\Pandoc;

class CheckFileFormatConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formats:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check file formats configuration';

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
        $formats = collect(data_get(FileFormat::config(), 'details'));

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

        $formatsWithShortDescription = $formats->whereNotNull('description')->filter(function ($item) {
            return count(explode(' ', $item['description'])) < 200;
        });
        if ($formatsWithShortDescription->count()) {
            $this->info('❌ The following formats have a description that’s shorter than 300 words: '.$formatsWithShortDescription->pluck('name')->implode(', '));
        }

        $formatsWithDefaultExtension = $formats->whereNotNull('default_extension')->count();
        $formatsWithDefaultExtensionPercentage = number_format(100/$formatsTotal * $formatsWithDefaultExtension, 1);
        $formatsWithDefaultExtensionStatus = $formatsWithDefaultExtension === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithDefaultExtensionStatus} {$formatsWithDefaultExtensionPercentage} % ({$formatsWithDefaultExtension}/{$formatsTotal}) have a default extension.");

        $formatsWithExtensions = $formats->whereNotNull('extensions')->count();
        $formatsWithExtensionsPercentage = number_format(100/$formatsTotal * $formatsWithExtensions, 1);
        $formatsWithExtensionsStatus = $formatsWithExtensions === $formatsTotal ? '✅' : '❌';
        $this->info("{$formatsWithExtensionsStatus} {$formatsWithExtensionsPercentage} % ({$formatsWithExtensions}/{$formatsTotal}) have allowed extensions.");

        $availableInputFileFormats = collect(
            Pandoc::listInputFormats(),
            Pandoc::listOutputFormats()
        );

        $deprecatedFileFormats = ['markdown_github'];
        $configuredFileFormats = $formats->pluck('name');
        $missingFileFormats = $availableInputFileFormats
            ->diff($configuredFileFormats)
            ->reject(function ($item) use ($deprecatedFileFormats) {
                return in_array($item, $deprecatedFileFormats);
            });

        if ($missingFileFormats->isEmpty()) {
            $this->info('✅ All available file formats are configured.');
        } else {
            $this->info('❌ The following file formats are not configured: '.$missingFileFormats->implode(', '));
        }
    }
}
