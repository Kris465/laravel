<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            // Страница-владелец нужна для кнопок вставки в админке. Внешний ключ
            // намеренно не создаём: страницы не удаляются, а настройки FK на
            // SQLite/MySQL хостинга могут отличаться.
            $table->unsignedBigInteger('page_id')->nullable()->index();
            $table->string('disk')->default('public');
            // Неизменный якорь: по нему находятся старые ссылки в текстах,
            // галерея и список документов. Фактическое расположение файла
            // лежит в file_path (см. следующую миграцию) и может меняться.
            $table->string('path')->unique();
            $table->string('collection', 32)->index(); // image | document | background
            $table->string('label')->nullable(); // человеческая подпись для менеджера
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
