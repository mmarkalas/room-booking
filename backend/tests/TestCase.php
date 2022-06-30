<?php

namespace Tests;

use App\Models\User;
use App\Services\UserService;
use Closure;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Authenticate user.
     *
     * @return void
     */
    private function authenticate()
    {
        // Create Fake User
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        // Set Auth User
        Passport::actingAs($user);
    }

    public function runCaseWithAuth(Closure $callback)
    {
        $this->authenticate();

        $callback();
    }
}
