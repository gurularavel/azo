<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('hero_stat_users_value')->nullable()->after('hero_secondary_url');
            $table->string('hero_stat_users_label')->nullable()->after('hero_stat_users_value');
            $table->string('hero_stat_partners_value')->nullable()->after('hero_stat_users_label');
            $table->string('hero_stat_partners_label')->nullable()->after('hero_stat_partners_value');
            $table->string('hero_stat_savings_value')->nullable()->after('hero_stat_partners_label');
            $table->string('hero_stat_savings_label')->nullable()->after('hero_stat_savings_value');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_stat_users_value',
                'hero_stat_users_label',
                'hero_stat_partners_value',
                'hero_stat_partners_label',
                'hero_stat_savings_value',
                'hero_stat_savings_label',
            ]);
        });
    }
};
