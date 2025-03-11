<?php

namespace Tests\Feature;

use Domain\Arena\Enums\TimeslotStatus;
use Domain\Arena\Models\Arena;
use Domain\Arena\Models\Timeslot;
use Domain\Booking\Actions\ConfirmBooking;
use Domain\Booking\Data\BookingData;
use Domain\Booking\Enums\BookingStatus;
use Domain\Booking\Models\Booking;
use Domain\Shared\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_books_an_available_timeslot()
    {
        $user = User::factory()->create();
        $arena = Arena::factory()->for($user)->create();
        $timeslot = Timeslot::factory()->create([
            'arena_id' => $arena->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'status' => TimeslotStatus::Available,
            'duration' => 60,
        ]);

        $bookingData = $this->handleTimeslotBooking($timeslot, $user->id);

        $this->assertDatabaseHas('bookings', [
            'id' => $bookingData->id,
            'time_slot_id' => $timeslot->id,
            'user_id' => $user->id,
            'status' => BookingStatus::Pending,
        ]);

        $this->assertEquals(TimeslotStatus::Booked, $timeslot->fresh()->status);
    }

    protected function handleTimeslotBooking(Timeslot $timeslot, int $user_id)
    {
        return DB::transaction(function () use ($timeslot, $user_id) {
            if (!$timeslot->available()) {
                throw new Exception("Timeslot is not available");
            }

            $booking = Booking::query()->create([
                'time_slot_id' => $timeslot->id,
                'user_id' => $user_id,
                'status' => BookingStatus::Pending,
                'expires_at' => now()->addMinutes(10),
            ]);

            $timeslot->booked();

            return BookingData::from($booking);
        });
    }
    public function test_it_confirms_a_pending_booking()
    {
        $user = User::factory()->create();
        $arena = Arena::factory()->for($user)->create();
        $timeslot = Timeslot::factory()->create([
            'arena_id' => $arena->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'status' => TimeslotStatus::Available,
            'duration' => 60,
        ]);
        $booking = Booking::query()->create([
            'time_slot_id' => $timeslot->id,
            'user_id' => $user->id,
            'status' => BookingStatus::Pending,
            'expires_at' => now()->addMinutes(10),
        ]);


        $action = new ConfirmBooking();
        $result = $action->handle($booking);

        $this->assertInstanceOf(BookingData::class, $result);
        $this->assertEquals(BookingStatus::Confirmed, $booking->fresh()->status);
        $this->assertEquals(TimeslotStatus::Reserved, $timeslot->fresh()->status);
    }

    public function test_it_throws_an_exception_if_booking_is_expired()
    {
        $user = User::factory()->create();
        $arena = Arena::factory()->for($user)->create();
        $timeslot = Timeslot::factory()->create([
            'arena_id' => $arena->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'status' => TimeslotStatus::Available,
            'duration' => 60,
        ]);
        $booking = Booking::query()->create([
            'time_slot_id' => $timeslot->id,
            'user_id' => $user->id,
            'status' => BookingStatus::Expired,
            'expires_at' => now()->addMinutes(10),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Booking Expired');

        $action = new ConfirmBooking();
        $action->handle($booking);
    }

    public function test_it_throws_an_exception_if_timeslot_is_not_available()
    {
        $user = User::factory()->create();
        $arena = Arena::factory()->for($user)->create();
        $timeslot = Timeslot::factory()->create([
            'arena_id' => $arena->id,
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'status' => TimeslotStatus::Booked,
            'duration' => 60,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Timeslot is not available");

        $this->handleTimeslotBooking($timeslot, $user->id);
    }
}