<?php

namespace App\Http\Controllers;

use Domain\Arena\Models\Timeslot;
use Domain\Booking\Actions\BookTimeslot;
use Domain\Booking\Actions\ConfirmBooking;
use Domain\Booking\Models\Booking;

class BookingController extends Controller
{
    public function store(Timeslot $timeslot)
    {
        return BookTimeslot::run($timeslot);
    }

    public function confirmBooking(Booking $booking)
    {
        return ConfirmBooking::run($booking);
    }
}
