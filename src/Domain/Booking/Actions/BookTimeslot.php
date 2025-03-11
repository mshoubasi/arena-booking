<?php

namespace Domain\Booking\Actions;

use Domain\Arena\Models\Timeslot;
use Domain\Booking\Data\BookingData;
use Domain\Booking\Enums\BookingStatus;
use Domain\Booking\Models\Booking;
use Exception;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class BookTimeslot
{
    use AsAction;

    public function handle(Timeslot $timeslot)
    {
        return DB::transaction(function () use ($timeslot) {
            if (!$timeslot->available()) {
                throw new Exception("Timeslot is not available");
            }
            $booking = Booking::query()->create([
                'time_slot_id' => $timeslot->id,
                'user_id' => auth()->user()->id,
                'status' => BookingStatus::Pending,
                'expires_at' => now()->addMinutes(10),
            ]);

            $timeslot->booked();

            return BookingData::from($booking);
        });
    }
}