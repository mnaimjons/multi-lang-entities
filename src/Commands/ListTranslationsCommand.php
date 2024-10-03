<?php

namespace Mnaimjons\MultiLangEntities\Commands;

use Illuminate\Console\Command;
use Mnaimjons\MultiLangEntities\Models\EntityTranslation;

class ListTranslationsCommand extends Command
{
    protected $signature = 'translations:list
                            {entity : The class name of the entity (e.g., App\\Models\\Category)}
                            {id : The ID of the entity}
                            {locale? : The locale of the translations (optional)}';

    protected $description = 'List all translations for a given entity and optionally for a specific locale.';

    public function handle()
    {
        $entity = $this->argument('entity');
        $id = $this->argument('id');
        $locale = $this->argument('locale');

        $query = EntityTranslation::where('entity_type', $entity)->where('entity_id', $id);

        if ($locale) {
            $query->where('locale', $locale);
        }

        $translations = $query->get();

        if ($translations->isEmpty()) {
            $this->info('No translations found.');
            return;
        }

        $this->table(['Attribute', 'Locale', 'Value'], $translations->map(function ($translation) {
            return [$translation->attribute, $translation->locale, $translation->value];
        })->toArray());
    }
}
