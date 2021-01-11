<?php

namespace Akkurate\LaravelAuth\Tests;

use Akkurate\LaravelCore\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;

class PasswordApiTest extends TestCase
{
    use WithFaker;

    /** @test * */
    public function it_should_update_password()
    {
        Passport::actingAs($this->user);

        $newPassword = $this->faker->password;

        $response = $this->post(route('api.auth.password.update', [
            'user' => $this->user,
            'old_password' => $this->user->password,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]));

        $response->assertStatus(200);
    }

    /** @test * */
    public function it_should_not_found_user()
    {
        Passport::actingAs($this->user);

        $newPassword = $this->faker->password;

        $response = $this->post(route('api.auth.password.update', [
            'user' => 56,
            'old_password' => $this->user->password,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]));

        $response->assertStatus(404);
    }

    /** @test * */
    public function it_should_not_found_user_id()
    {
        Passport::actingAs($this->user);

        $user = User::create([
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => 'email@test.com',
            'account_id' => $this->user->account->id,
            'activated_at' => Carbon::now(),
            'email_verified_at' => Carbon::now()
        ]);

        $newPassword = $this->faker->password;

        $response = $this->post(route('api.auth.password.update', [
            'user' => $user,
            'old_password' => $this->user->password,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]));

        $response->assertStatus(403);
    }

    /** @test * */
    public function it_should_not_update_password()
    {
        Passport::actingAs($this->user);

        $newPassword = $this->faker->password;

        $response = $this->post(route('api.auth.password.update', [
            'user' => $this->user,
            'old_password' => 'wrong_password',
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]));

        $response->assertStatus(404);
    }
}
