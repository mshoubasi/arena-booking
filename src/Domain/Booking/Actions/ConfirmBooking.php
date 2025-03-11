<?php

namespace Domain\Booking\Actions;

use Domain\Arena\Models\Timeslot;
use Domain\Booking\Data\BookingData;
use Domain\Booking\Enums\BookingStatus;
use Domain\Booking\Models\Booking;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class ConfirmBooking
{
    use AsAction;

    public function handle(Booking $booking)
    {
        return DB::transaction(function () use ($booking) {
            $booking->lockForUpdate();

            if (!$booking->pending()) {
                throw new \Exception('Booking Expired');
            }
            $booking->confirmed();
            $timeslot = Timeslot::where('id', $booking->time_slot_id)->first();
            $timeslot->reserved();
            return BookingData::from($booking);
        });
    }
}
