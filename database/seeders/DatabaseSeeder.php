<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DeviceTypeSeeder;
use Database\Seeders\BrandsSeeder;
use Database\Seeders\ModelsSeeder;
use Database\Seeders\DeviceSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(class: [
            DeviceTypeSeeder::class,
            BrandsSeeder::class,
            ModelsSeeder::class,
            DeviceSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'asdfsdaf',
            'email' => 'ana@gmail.com',
            'password' => 'Ana123456'
        ]);
    }

}
