<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example works.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = User::create([
            'company_id' => 0,
            'name' => 'Kamsi Cruise',
            'email' => 'kk@gmail.com',
            'account_type' => 'Admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ]);
        $this->assertCount(1, User::all());
        $this->assertTrue(true);
    }
}
