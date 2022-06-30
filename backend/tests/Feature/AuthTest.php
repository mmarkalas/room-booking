<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class AuthTest extends TestCase
{
    public function testRegister()
    {
        $currTime = time();

        $response = $this->json('POST', '/api/register', [
            'name' => 'Reg Test',
            'username' => 'RegTest' . $currTime,
            'email' =>  $currTime . 'regtest@example.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        //Write the response in test logs
        Log::channel('test')
            ->info(1, [$response->getContent()]);

        // Assert Success Response
        $response->assertStatus(200);

        $respArray = $response->json();

        // Assert Response Data
        $this->assertArrayHasKey('data', $respArray);

        // Assert Auth User
        $this->assertArrayHasKey('user', $respArray['data']);

        // Assert Access Token
        $this->assertArrayHasKey('access_token', $respArray['data']);
    }

    public function testLogin()
    {
        $userService = app()->make(UserService::class);

        // Create User
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        // Simulated landing
        $response = $this->json('POST', '/api/login', [
            'username' => $user->username,
            'password' => 'password',
        ]);

        //Write the response in test logs
        Log::channel('test')
            ->info(1, [$response->getContent()]);

        // Assert Success Response
        $response->assertStatus(200);

        $respArray = $response->json();

        // Assert Response Data
        $this->assertArrayHasKey('data', $respArray);

        // Assert Access Token
        $this->assertArrayHasKey('access_token', $respArray['data']);

        // Delete user
        $userService->delete($user);
    }

    public function testLogout()
    {
        $this->runCaseWithAuth(function () {
            $response = $this->json('POST', '/api/logout');

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);
        });
    }
}
