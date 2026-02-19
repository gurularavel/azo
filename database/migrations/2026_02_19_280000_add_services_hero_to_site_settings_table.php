<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('services_hero_title')->nullable()->after('privacy_content');
            $table->text('services_hero_subtitle')->nullable()->after('services_hero_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['services_hero_title', 'services_hero_subtitle']);
        });
    }
};
