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
        \App\Models\User::factory([
                                        'company_id' => 0, 
                                        'email' => 'test@test.com', 
                                        'account_type' => 'Admin'
                                    ])->create();
        // $companies = \App\Models\Company::factory()->count(10)->make();
        $this->call([CompanySeeder::class]);
    }
}
