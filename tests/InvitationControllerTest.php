<?php

namespace Akkurate\LaravelAuth\Tests;

use Akkurate\LaravelCore\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

class InvitationControllerTest extends TestCase
{
    use WithFaker;

    /** @test **/
    public function it_should_verify_user_and_log_in_him_then_redirect()
    {
        $this->assertAuthenticatedAs($this->user);

        $user = User::create([
            'email' => 'email@test.com',
            'account_id' => $this->user->account->id,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'activation_token' => Str::random(60).'_'.time()
        ]);

        $response = $this->get(route('verify.user', [
            'token' => $user->activation_token,
        ]));

        $response->assertRedirect('register/complete-profile');

        $this->assertAuthenticatedAs($user);
    }

    /** @test **/
    public function it_should_update_profile_with_firstname_and_lastname_then_redirect_to_dashboard()
    {
        $user = User::create([
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => 'email@test.com',
            'account_id' => $this->user->account->id,
            'activated_at' => Carbon::now(),
            'email_verified_at' => Carbon::now()
        ]);

        auth()->login($user);

        $password = $this->faker->password;

        $response = $this->patch(route('register.profile.update', [
            'password' => $password,
            'password_confirmation' => $password,
        ]));

        $response->assertRedirect(config('laravel-core.admin.route'));
    }

    /** @test **/
    public function it_should_update_profile_without_firstname_and_lastname_then_redirect_to_dashboard()
    {
        $user = User::create([
            'email' => 'email@test.com',
            'account_id' => $this->user->account->id,
            'activated_at' => Carbon::now(),
            'email_verified_at' => Carbon::now()
        ]);

        auth()->login($user);

        $password = $this->faker->password;

        $response = $this->patch(route('register.profile.update', [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'password' => $password,
            'password_confirmation' => $password,
        ]));

        $response->assertRedirect(config('laravel-core.admin.route'));
    }
}
