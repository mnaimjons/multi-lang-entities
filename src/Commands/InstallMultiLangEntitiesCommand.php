<?php

namespace Mnaimjons\MultiLangEntities\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallMultiLangEntitiesCommand extends Command
{
    protected $signature = 'multi-lang-entities:install';

    protected $description = 'Install the MultiLangEntities package by publishing its configuration file.';

    public function handle()
    {
        $configPath = config_path('multi_lang_entities.php');

        if (File::exists($configPath)) {
            $this->info('The configuration file already exists.');
            $this->comment('If you want to republish the configuration file, use the --force flag.');
        } else {
            $this->publishConfig();
            $this->info('MultiLangEntities configuration file has been published.');
        }
    }

    /**
     * Publish the configuration file.
     */
    private function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => "Mnaimjons\MultiLangEntities\MultiLangEntitiesServiceProvider",
            '--tag' => 'config',
            '--force' => true,
        ]);
    }
}

