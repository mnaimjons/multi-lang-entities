<?php

namespace Mnaimjons\MultiLangEntities\Commands;

use Illuminate\Console\Command;
use Mnaimjons\MultiLangEntities\Models\EntityTranslation;

class AddTranslationCommand extends Command
{
    protected $signature = 'translations:add
                            {entity : The class name of the entity (e.g., App\\Models\\Category)}
                            {id : The ID of the entity}
                            {locale : The locale of the translation}
                            {attribute : The attribute to translate}
                            {value : The translated value}';

    protected $description = 'Add or update a translation for a given entity, attribute, and locale.';

    public function handle()
    {
        $entity = $this->argument('entity');
        $id = $this->argument('id');
        $locale = $this->argument('locale');
        $attribute = $this->argument('attribute');
        $value = $this->argument('value');

        EntityTranslation::updateOrCreate(
            [
                'entity_type' => $entity,
                'entity_id' => $id,
                'locale' => $locale,
                'attribute' => $attribute,
            ],
            ['value' => $value]
        );

        $this->info("Translation for attribute '{$attribute}' in locale '{$locale}' has been added/updated successfully.");
    }
}
