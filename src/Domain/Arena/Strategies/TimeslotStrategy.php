<?php

namespace Domain\Arena\Strategies;

use Domain\Arena\Data\ArenaData;
use Domain\Arena\Data\TimeslotData;
use Domain\Arena\Models\Arena;
use Domain\Arena\Models\Timeslot;

interface TimeslotStrategy
{
    public function createTimeSlot(TimeslotData $data, int $arena_id): Timeslot;
}