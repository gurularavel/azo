<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'label', 'permissions', 'is_system'];

    protected $casts = [
        'permissions' => 'array',
        'is_system'   => 'boolean',
    ];

    /** All controllable admin sections (slug => translation key) */
    public const SECTIONS = [
        'shops'            => 'messages.manage_shops',
        'shop-categories'  => 'messages.manage_categories',
        'cities'           => 'messages.manage_cities',
        'users'            => 'messages.manage_users',
        'roles'            => 'messages.manage_roles',
        'plans'            => 'messages.manage_plans',
        'transactions'     => 'messages.transaction_logs',
        'reports'          => 'messages.revenue_reports',
        'blogs'            => 'messages.manage_blogs',
        'services'         => 'messages.manage_services',
        'hero-slides'      => 'messages.manage_slides',
        'features'         => 'messages.manage_features',
        'partners'         => 'messages.manage_partners',
        'subscribers'      => 'messages.manage_subscribers',
        'contact-messages' => 'messages.manage_contact_messages',
        'site-settings'    => 'messages.site_settings',
        'translations'     => 'messages.manage_translations',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role', 'name');
    }
}
