<?php

namespace Mnaimjons\MultiLangEntities;

use Illuminate\Support\ServiceProvider;
use Mnaimjons\MultiLangEntities\Commands\ListTranslationsCommand;
use Mnaimjons\MultiLangEntities\Commands\AddTranslationCommand;
use Mnaimjons\MultiLangEntities\Commands\RemoveTranslationCommand;
use Mnaimjons\MultiLangEntities\Commands\InstallMultiLangEntitiesCommand;

class MultiLangEntitiesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/multi_lang_entities.php', 'multi_lang_entities');
    }

    public function boot()
    {
        // Публикация миграций
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Публикация конфигурации
        $this->publishes([
            __DIR__ . '/../config/multi_lang_entities.php' => config_path('multi_lang_entities.php'),
        ], 'config');

        // Регистрация команд
        if ($this->app->runningInConsole()) {
            $this->commands([
                ListTranslationsCommand::class,
                AddTranslationCommand::class,
                RemoveTranslationCommand::class,
                InstallMultiLangEntitiesCommand::class, // Добавлена команда установки пакета
            ]);
        }
    }
}
