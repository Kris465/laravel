<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Текущий физический путь. NULL = файл всё ещё лежит по `path`.
            // Если хостинг переименовал файл, правится ТОЛЬКО это поле —
            // якорь `path` и все /media/{id} остаются прежними.
            $table->string('file_path', 191)->nullable()->after('path');
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
