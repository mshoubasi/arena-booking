<?php

namespace Domain\Arena\Strategies;

use Carbon\Carbon;
use Domain\Arena\Data\TimeslotData;
use Domain\Arena\Models\Timeslot;
use Exception;

class AvailableTimeslot implements TimeslotStrategy
{
    /**
     * @throws Exception
     */
    public function createTimeSlot(TimeslotData $data, int $arena_id): Timeslot
    {
        $startTime = Carbon::parse($data->start_time);
        $endTime = $startTime->copy()->addMinutes($data->duration);

        if (Timeslot::query()->overlaps($startTime, $endTime)) {
            throw new Exception('TimeSlot already overlaps');
        }

        return Timeslot::query()->create([
            'arena_id' => $arena_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration' => $data->duration,
        ]);
    }
}