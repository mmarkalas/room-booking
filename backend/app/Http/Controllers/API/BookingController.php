<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\SearchRequest;
use App\Http\Requests\Booking\StoreRequest;
use App\Http\Resources\Booking\BookingCollection;
use App\Http\Resources\Booking\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;

class BookingController extends Controller
{
    private $bookingService;

    public function __construct(BookingService $bookingService) {
        parent::__construct();
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchRequest $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $bookings = $this->bookingService
                ->search($request->validated());

            return $this->response->setData(
                new BookingCollection($bookings, true)
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
            $booking = $this->bookingService
                ->createBooking($request->validated());

            return $this->response->setData(
                new BookingResource($booking)
            );
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return $this->runWithExceptionHandling(function () use ($booking) {
            return $this->response->setData(
                new BookingResource($booking)
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
    public function update(StoreRequest $request, Booking $booking)
    {
        return $this->runWithExceptionHandling(function () use ($request, $booking) {
            $booking = $this->bookingService
                ->updateBooking($request->validated(), $booking);

            return $this->response->setData(
                new BookingResource($booking)
            );
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        return $this->runWithExceptionHandling(function () use ($booking) {
            $this->bookingService->delete($booking);

            return $this->response;
        });
    }
}
