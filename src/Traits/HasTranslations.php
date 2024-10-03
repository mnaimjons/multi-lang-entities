<?php

namespace Mnaimjons\MultiLangEntities\Traits;

use Mnaimjons\MultiLangEntities\Models\EntityTranslation;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

trait HasTranslations
{
    protected bool $loadTranslationsEagerly = false;

    /**
     * Boot the trait and register model events.
     */
    public static function bootHasTranslations()
    {
        static::deleting(function ($model) {
            $model->translations()->delete();
        });

        static::retrieved(function ($model) {
            $model->initializeTranslatableAttributes();
        });
    }

    /**
     * Инициализация переводимых атрибутов.
     */
    protected function initializeTranslatableAttributes(): void
    {
        foreach ($this->getTranslatableAttributes() as $attribute) {
            if (!method_exists($this, 'get' . ucfirst($attribute) . 'Attribute')) {
                $this->addTranslatableAccessor($attribute);
            }
        }
    }

    /**
     * Получение переводимых атрибутов.
     */
    protected function getTranslatableAttributes(): array
    {
        return property_exists($this, 'translatable') ? $this->translatable : [];
    }

    /**
     * Связь с таблицей переводов.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(EntityTranslation::class, 'entity_id')
            ->where('entity_type', $this->getEntityType());
    }

    /**
     * Получение типа сущности.
     */
    protected function getEntityType(): string
    {
        return static::class; // Универсальное определение типа сущности
    }

    /**
     * Включить eager загрузку переводов.
     */
    public function withTranslations(): self
    {
        $this->loadTranslationsEagerly = true;
        return $this;
    }

    /**
     * Получение перевода атрибута с возможностью ленивой или eager загрузки.
     */
    public function getTranslatedAttribute(string $attribute, ?string $locale = null): ?string
    {
        $locale = $locale ?? App::getLocale();

        if ($this->loadTranslationsEagerly) {
            $translation = $this->translations->firstWhere('attribute', $attribute)
                ->where('locale', $locale);
        } else {
            $translation = $this->translations()->where('attribute', $attribute)
                ->where('locale', $locale)
                ->first();
        }

        return $translation ? $translation->value : $this->getAttribute($attribute);
    }

    /**
     * Установка переводов для нескольких атрибутов.
     */
    public function setTranslations(array $attributes, string $locale): self
    {
        foreach ($attributes as $attribute => $value) {
            $this->translations()->updateOrCreate(
                ['entity_type' => $this->getEntityType(), 'entity_id' => $this->id, 'locale' => $locale, 'attribute' => $attribute],
                ['value' => $value]
            );
        }

        return $this;
    }

    /**
     * Добавление динамического Accessor для переводимого атрибута.
     */
    protected function addTranslatableAccessor(string $attribute): void
    {
        $methodName = 'get' . ucfirst($attribute) . 'Attribute';
        $this->{$methodName} = function () use ($attribute) {
            return $this->getTranslatedAttribute($attribute);
        };
    }
}
