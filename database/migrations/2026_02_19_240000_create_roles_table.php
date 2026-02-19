<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // slug: admin, editor …
            $table->string('label');           // display name
            $table->json('permissions')->nullable(); // ['shops','blogs',…]
            $table->boolean('is_system')->default(false);
            $table->timestamps();
        });

        $all = ['shops','shop-categories','cities','users','roles','plans',
                'transactions','reports','blogs','services','hero-slides',
                'features','partners','site-settings','translations'];

        $adminDefault = array_values(array_diff($all, ['roles','translations','site-settings']));

        DB::table('roles')->insert([
            ['name' => 'user',       'label' => 'User',       'permissions' => json_encode([]),          'is_system' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin',      'label' => 'Admin',      'permissions' => json_encode($adminDefault),'is_system' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'superadmin', 'label' => 'Superadmin', 'permissions' => json_encode($all),         'is_system' => true,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
