<?php

namespace Database\Seeders;

use App\Models\Auther;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auther::factory()->count(10)->create();

    }
}
