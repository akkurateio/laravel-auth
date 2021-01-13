<?php

namespace Akkurate\LaravelAuth\Tests;

use Akkurate\LaravelCore\Providers\LaravelAccessServiceProvider;
use Akkurate\LaravelCore\Providers\LaravelAdminServiceProvider;
use Akkurate\LaravelCore\Models\Account;
use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Models\User;
use Akkurate\LaravelAuth\LaravelAuthServiceProvider;
use Akkurate\LaravelBackComponents\LaravelBackComponentsServiceProvider;
use Akkurate\LaravelCore\LaravelCoreServiceProvider;
use Cviebrock\EloquentSluggable\ServiceProvider as EloquentSluggableServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends OrchestraTestCase
{

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->createUser();

        $this->user = User::first();
        auth()->login($this->user);

        $this->user->preference()->create([
            'preferenceable_type' => 'Akkurate\LaravelCore\Models\User',
            'preferenceable_id' => $this->user->id,
            'target' => 'both',
            'pagination' => 30,
            'language_id' => Language::where('locale', 'fr')->first()->id
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');

        //Set the mail environment
        $app['config']->set('mail.from.address', 'hello@subvitamine.com');
        $app['config']->set('mail.from.name', 'Subvitamine');
        $app['config']->set('mail.mailers.smtp.host', 'maildev');
        $app['config']->set('mail.mailers.smtp.port', 25);
        $app['config']->set('mail.mailers.smtp.encryption', null);
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelAuthServiceProvider::class,
            LaravelBackComponentsServiceProvider::class,
            LaravelAdminServiceProvider::class,
            EloquentSluggableServiceProvider::class,
            LaravelCoreServiceProvider::class,
            LaravelAccessServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $this->loadMigrationsFrom(__DIR__ . '/../vendor/akkurateio/laravel-core/database/laravel-access/migrations');
        $this->seed(\Akkurate\LaravelCore\Database\Seeders\Access\DatabaseSeeder::class);

        $this->loadMigrationsFrom(__DIR__ . '/../vendor/akkurateio/laravel-core/database/laravel-admin/migrations');
        $this->seed(\Akkurate\LaravelCore\Database\Seeders\Admin\LanguagesTableSeeder::class);
        $this->seed(\Akkurate\LaravelCore\Database\Seeders\Admin\CountriesTableSeeder::class);
    }

    protected function createUser()
    {
        $account = Account::create([
            'name' => 'Account',
            'email' => 'account@email.com',
        ]);

        User::forceCreate([
            'firstname' => 'User',
            'lastname' => 'Lastname',
            'email' => 'user@email.com',
            'password' => Hash::make('test'),
            'account_id' => $account->id,
        ]);
    }
}
