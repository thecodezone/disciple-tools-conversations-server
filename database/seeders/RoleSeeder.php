<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::all()->pluck('name')->toArray();

        Role::updateOrCreate([
            'id' => 1,
            'name' => 'developer',
        ])->givePermissionTo(
            Permission::all()->pluck('name')->toArray()
        );

        Role::updateOrCreate([
            'id' => 2,
            'name' => 'admin',
        ])->givePermissionTo(
            Permission::where(
                'name', '!=' , 'access horizon'
            )->pluck('name')->toArray()
        );

        Artisan::call('permissions:sync');
    }
}
