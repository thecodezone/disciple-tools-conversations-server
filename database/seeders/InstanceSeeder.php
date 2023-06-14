<?php

namespace Database\Seeders;

use App\Models\Instance;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Instance::updateOrCreate(
            [ 'id' => 1 ],
            Instance::factory()->make()->toArray(),
        )->users()->sync([
            User::inRandomOrder()->limit(1)->first()->id
        ]);

        Instance::updateOrCreate(
            [ 'id' => 2 ],
            Instance::factory()->make()->toArray()
        )->users()->sync([
            User::inRandomOrder()->limit(1)->first()->id
        ]);
    }
}
