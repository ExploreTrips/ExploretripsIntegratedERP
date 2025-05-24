<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i=1; $i<=4; $i++){
            DB::table('employees')->insert([
                'user_id' => 2,
                'branch_id' => 1,
                'department_id' => 1,
                'designation_id' => 1,
                'name' => $faker->name,
                'dob' => $faker->date('Y-m-d', '2000-01-01'),
                'gender' => $faker->randomElement(['male', 'female']),
                'phone' => $faker->numerify('98########'),
                'address' => $faker->address,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'employee_id' => 'EMP' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'company_doj' => $faker->date(),
                'documents' => json_encode([$faker->word . '.pdf']),
                'account_holder_name' => $faker->name,
                'account_number' => $faker->bankAccountNumber,
                'bank_name' => $faker->company . ' Bank',
                'bank_ifsc_code' => strtoupper(Str::random(11)),
                'branch_location' => $faker->city,
                'tax_payer_id' => strtoupper($faker->bothify('???#####')),
                'salary_type' => rand(1, 2), // 1: Monthly, 2: Hourly etc.
                'salary' => rand(25000, 75000),
                'is_active' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}
