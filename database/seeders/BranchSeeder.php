<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $i) {
            DB::table('branches')->insert([
                'name' => $faker->city,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
