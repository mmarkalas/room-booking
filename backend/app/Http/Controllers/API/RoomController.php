<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRequest;
use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;
use App\Models\Room;
use App\Services\RoomService;

class RoomController extends Controller
{
    private $roomService;

    public function __construct(RoomService $roomService)
    {
        parent::__construct();
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->runWithExceptionHandling(function () {
            $rooms = $this->roomService->all();

            return $this->response->setData(
                new RoomCollection($rooms, true)
            );
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $room = $this->roomService->create($request->validated());

            return $this->response->setData(
                new RoomResource($room)
            );
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return $this->runWithExceptionHandling(function () use ($room) {
            return $this->response->setData(
                new RoomResource($room)
            );
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Room $room)
    {
        return $this->runWithExceptionHandling(function () use ($request, $room) {
            $room = $this->roomService->update($room, $request->validated());

            return $this->response->setData(
                new RoomResource($room)
            );
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        return $this->runWithExceptionHandling(function () use ($room) {
            $this->roomService->delete($room);

            return $this->response;
        });
    }
}
