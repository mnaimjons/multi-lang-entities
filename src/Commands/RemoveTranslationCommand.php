<?php

namespace Mnaimjons\MultiLangEntities\Commands;

use Illuminate\Console\Command;
use Mnaimjons\MultiLangEntities\Models\EntityTranslation;

class RemoveTranslationCommand extends Command
{
    protected $signature = 'translations:remove
                            {entity : The class name of the entity (e.g., App\\Models\\Category)}
                            {id : The ID of the entity}
                            {locale : The locale of the translation}
                            {attribute : The attribute to remove translation from}';

    protected $description = 'Remove a translation for a given entity, attribute, and locale.';

    public function handle()
    {
        $entity = $this->argument('entity');
        $id = $this->argument('id');
        $locale = $this->argument('locale');
        $attribute = $this->argument('attribute');

        $translation = EntityTranslation::where('entity_type', $entity)
            ->where('entity_id', $id)
            ->where('locale', $locale)
            ->where('attribute', $attribute)
            ->first();

        if (!$translation) {
            $this->info("No translation found for attribute '{$attribute}' in locale '{$locale}'.");
            return;
        }

        $translation->delete();

        $this->info("Translation for attribute '{$attribute}' in locale '{$locale}' has been removed successfully.");
    }
}
