<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Utility;
use Illuminate\Database\Seeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PlansTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\DesignationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UsersTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(EmployeeSeeder::class);
        Utility::languagecreate();






        // if(!file_exists(storage_path() . "/installed"))
        // {
        //     // $this->call(PlansTableSeeder::class);
        //     // $this->call(UsersTableSeeder::class);
        //     // $this->call(AiTemplateSeeder::class);

        // }else{
        //     Utility::languagecreate();

        // }
    }
}
