<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 6; $i++) {
            Service::updateOrCreate(
                [ 'id' => $i ],
                Service::factory()->make()->toArray(),
            );
        }
    }
}
