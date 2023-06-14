<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate([
            'id' => 1,
            'name' => 'access admin',
        ]);

        Permission::updateOrCreate([
            'id' => 2,
            'name' => 'access horizon',
        ]);

        Artisan::call('permissions:sync');
    }
}
