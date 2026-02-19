<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'hero_title',
        'hero_subtitle',
        'hero_primary_text',
        'hero_primary_url',
        'hero_secondary_text',
        'hero_secondary_url',
        'hero_stat_users_value',
        'hero_stat_users_label',
        'hero_stat_partners_value',
        'hero_stat_partners_label',
        'hero_stat_savings_value',
        'hero_stat_savings_label',
        'contact_email',
        'contact_phone',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'footer_text',
    ];
}
