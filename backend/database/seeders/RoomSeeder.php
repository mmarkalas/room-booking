<?php

namespace Database\Seeders;


use App\Services\RoomService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomService = app()->make(RoomService::class);
        $now = Carbon::now()->toDateTimeString();

        $roomService->insert([
            ['name' => fake()->buildingNumber(), 'created_at' => $now, 'updated_at' => $now],
            ['name' => fake()->buildingNumber(), 'created_at' => $now, 'updated_at' => $now],
            ['name' => fake()->buildingNumber(), 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
