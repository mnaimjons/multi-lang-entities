<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('entity_translations', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type'); // Тип сущности, например, 'App\Models\Service'
            $table->unsignedBigInteger('entity_id'); // ID сущности, например, service_id
            $table->string('locale')->index(); // Код языка, например, 'en', 'fr'
            $table->string('attribute'); // Атрибут, например, 'name' или 'description'
            $table->text('value'); // Значение атрибута на указанном языке
            $table->timestamps();

            $table->unique(['entity_type', 'entity_id', 'locale', 'attribute'], 'entity_locale_attribute_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('entity_translations');
    }
}
