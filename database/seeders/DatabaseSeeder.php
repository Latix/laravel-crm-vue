<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Company::factory(10)->create();
        // $companies = \App\Models\Company::factory()->count(10)->make();
        $this->call([CompanySeeder::class]);
    }
}
