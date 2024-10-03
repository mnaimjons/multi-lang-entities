<?php

namespace Mnaimjons\MultiLangEntities\Models;

use Illuminate\Database\Eloquent\Model;

class EntityTranslation extends Model
{
    protected $fillable = ['entity_type', 'entity_id', 'locale', 'attribute', 'value'];

    /**
     * Получить родительскую сущность для перевода.
     */
    public function translatable()
    {
        return $this->morphTo(__FUNCTION__, 'entity_type', 'entity_id');
    }
}
