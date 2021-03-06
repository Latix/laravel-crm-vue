<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Company::factory()->count(20)->create()->each(function ($company) {
            $company->users()->saveMany(\App\Models\User::factory(['account_type' => 'Manager'])->count(1)->make());
            $company->users()->saveMany(\App\Models\User::factory()->count(2)->make());
        });
    }
}
