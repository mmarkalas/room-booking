<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class BookingTest extends TestCase
{
    /**
     * Get Bookings
     *
     * @return void
     */
    public function testGetBookings()
    {
        $this->runCaseWithAuth(function () {
            $response = $this->json('GET', '/api/bookings');

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
     * Get Booking
     *
     * @return void
     */
    public function testGetBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Booking
            $booking = Booking::factory()->create();

            $response = $this->json('GET', "/api/bookings/$booking->id");

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
     * Get Booking Not Found
     *
     * @return void
     */
    public function testNotFoundGetBooking()
    {
        $this->runCaseWithAuth(function () {
            $response = $this->json('GET', "/api/bookings/test-" . time());

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
     * Create Booking
     *
     * @return void
     */
    public function testCreateBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Fake User
            $booking = Booking::factory()->make();

            $response = $this->json('POST', '/api/bookings', [
                'room_id' => $booking->room_id,
                'from_date' => $booking->from_date->toDateTimeString(),
                'to_date' => $booking->to_date->toDateTimeString(),
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
     * Invalid Timefame On Create Booking
     *
     * @return void
     */
    public function testInvalidTimefameOnCreateBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Fake User
            $booking = Booking::factory()->make();

            $response = $this->json('POST', '/api/bookings', [
                'room_id' => $booking->room_id,
                'from_date' => $booking->from_date->setTime(6, 0)->toDateTimeString(),
                'to_date' => $booking->to_date->setTime(6, 30)->toDateTimeString(),
            ]);

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Unprocessable Entity Response
            $response->assertStatus(422);

            // Assert Response Data
            $this->assertArrayHasKey('data', $response->json());

            // Assert Response From Data
            $this->assertArrayHasKey('from_date', $response->json()['data']);
        });
    }

    /**
     * Different Day On Create Booking
     *
     * @return void
     */
    public function testDifferentDayOnCreateBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Fake User
            $booking = Booking::factory()->make();

            $response = $this->json('POST', '/api/bookings', [
                'room_id' => $booking->room_id,
                'from_date' => $booking->from_date->toDateTimeString(),
                'to_date' => $booking->to_date->addDay()->toDateTimeString(),
            ]);

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Unprocessable Entity Response
            $response->assertStatus(422);

            // Assert Response Data
            $this->assertArrayHasKey('data', $response->json());

            // Assert Response From Date
            $this->assertArrayHasKey('from_date', $response->json()['data']);

            // Assert Response To Date
            $this->assertArrayHasKey('to_date', $response->json()['data']);
        });
    }

    /**
     * Room Already Booked On Create Booking
     *
     * @return void
     */
    public function testRoomAlreadyBookedOnCreateBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Fake User
            $booking = Booking::inRandomOrder()->first();

            $response = $this->json('POST', '/api/bookings', [
                'room_id' => $booking->room_id,
                'from_date' => $booking->from_date->addMinutes(30)->toDateTimeString(),
                'to_date' => $booking->to_date->addMinutes(30)->toDateTimeString(),
            ]);

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Unprocessable Entity Response
            $response->assertStatus(422);

            // Assert Response Data
            $this->assertArrayHasKey('message', $response->json());

            // Assert Response Data
            $this->assertStringContainsString('already booked', $response->json()['message']);
        });
    }

    /**
     * Update Booking
     *
     * @return void
     */
    public function testUpdateBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Booking
            $booking = Booking::factory()->create();

            $response = $this->json('PUT', "/api/bookings/$booking->id", [
                'room_id' => $booking->room_id,
                'from_date' => $booking->from_date->addMinutes(30)->toDateTimeString(),
                'to_date' => $booking->to_date->addMinutes(30)->toDateTimeString(),
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
     * Delete Booking
     *
     * @return void
     */
    public function testDeleteBooking()
    {
        $this->runCaseWithAuth(function () {
            // Create Booking
            $booking = Booking::factory()->create();

            $response = $this->json('DELETE', "/api/bookings/$booking->id");

            //Write the response in test logs
            Log::channel('test')
                ->info(1, [$response->getContent()]);

            // Assert Success Response
            $response->assertStatus(200);
        });
    }
}
