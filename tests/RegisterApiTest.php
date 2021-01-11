<?php

namespace Akkurate\LaravelAuth\Tests;

use Akkurate\LaravelCore\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;

class RegisterApiTest extends TestCase
{
    use WithFaker;

    /** @test **/
    public function it_should_register_a_user_with_password()
    {
        Config::set('laravel-auth.allow_register', true);

        $password = $this->faker->password;

        $response = $this->post(route('api.auth.register', [
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => 'email@test.fr',
            'password' => $password,
            'password_confirmation' => $password,
        ]));
        $response->assertStatus(201);

        $user = User::where('email', 'email@test.fr')->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test **/
    public function it_should_register_a_user_without_password()
    {
        $response = $this->post(route('api.auth.register', [
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => 'email@test.fr',
        ]));
        $response->assertStatus(201);

        $user = User::where('email', 'email@test.fr')->first();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

}
