<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Room;
use Illuminate\Support\Facades\Log;

class RoomTest extends TestCase
{
    /**
     * Get Rooms
     *
     * @return void
     */
    public function testGetRooms()
    {
        $this->runCaseWithAuth(function () {
            $response = $this->json('GET', '/api/rooms');

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);

            // Assert Response Data
            $this->assertArrayHasKey('data', $response->json());
        });
    }

    /**
     * Get Room
     *
     * @return void
     */
    public function testGetRoom()
    {
        $this->runCaseWithAuth(function () {
            // Create Room
            $room = Room::factory()->create();

            $response = $this->json('GET', "/api/rooms/$room->id");

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);

            // Assert Response Data
            $this->assertArrayHasKey('data', $response->json());
        });
    }

    /**
     * Get Room Not Found
     *
     * @return void
     */
    public function testNotFoundGetRoom()
    {
        $this->runCaseWithAuth(function () {
            $response = $this->json('GET', "/api/rooms/test-" . time());

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Not Found Response
            $response->assertStatus(404);

            // Assert Response Message
            $this->assertArrayHasKey('message', $response->json());

            // Assert Message Contains
            $this->assertStringContainsString('not found', $response->json()['message']);
        });
    }

    /**
     * Create Room
     *
     * @return void
     */
    public function testCreateRoom()
    {
        $this->runCaseWithAuth(function () {
            // Create Fake Room
            $room = Room::factory()->make();

            $response = $this->json('POST', '/api/rooms', [
                'name' => $room->name
            ]);

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);

            // Assert Response Data
            $this->assertArrayHasKey('data', $response->json());
        });
    }

    /**
     * Update Room
     *
     * @return void
     */
    public function testUpdateRoom()
    {
        $this->runCaseWithAuth(function () {
            // Create Room
            $room = Room::factory()->create();

            $response = $this->json('PUT', "/api/rooms/$room->id", [
                'name' => $room->name . " EDIT-" . time()
            ]);

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);

            // Assert Response Data
            $this->assertArrayHasKey('data', $response->json());
        });
    }

    /**
     * Delete Room
     *
     * @return void
     */
    public function testDeleteRoom()
    {
        $this->runCaseWithAuth(function () {
            // Create Room
            $room = Room::factory()->create();

            $response = $this->json('DELETE', "/api/rooms/$room->id");

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);
        });
    }
}
