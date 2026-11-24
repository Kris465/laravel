<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Лента блоков (новости). longText + cast 'array', как images/documents:
     * JSON-колонки на MySQL хостинга в этом проекте не используются.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->longText('blocks')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('blocks');
        });
    }
};
