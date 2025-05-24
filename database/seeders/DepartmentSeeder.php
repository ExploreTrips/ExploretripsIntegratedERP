<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            DB::table('departments')->insert([
                'branch_id' => 1,
                'name' => $faker->word,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
