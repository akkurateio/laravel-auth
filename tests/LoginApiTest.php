<?php

namespace Akkurate\LaravelAuth\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;

class LoginApiTest extends TestCase
{
    use WithFaker;

    /** @test * */
    public function it_should_log_out_user()
    {
        Passport::actingAs($this->user);

        $response = $this->post(route('api.auth.logout'));

        $response->assertStatus(200);
    }
}
