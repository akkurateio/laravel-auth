<?php

namespace Akkurate\LaravelAuth\Tests;

use Illuminate\Foundation\Testing\WithFaker;

class LoginControllerTest extends TestCase
{
    use WithFaker;

    /** @test **/
    public function it_should_log_out_user()
    {
        $this->assertAuthenticatedAs($this->user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(config('laravel-core.admin.route'));
    }

}
