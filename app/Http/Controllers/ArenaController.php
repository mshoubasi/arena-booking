<?php

namespace App\Http\Controllers;

use Domain\Arena\Data\ArenaData;
use Domain\Arena\Data\TimeslotData;
use Domain\Arena\Strategies\AvailableTimeslot;
use Domain\Arena\Models\Arena;

class ArenaController extends Controller
{
    public function __construct(protected AvailableTimeslot $factory)
    {
    }

    public function store(ArenaData $data)
    {
        $arena = Arena::query()->create($data->toArray());

        return ArenaData::from($arena);
    }

    public function createTimeslot(Arena $arena,TimeslotData $data)
    {
        $timeslot = $this->factory->createTimeslot($data, $arena->id);

        return TimeslotData::from($timeslot);
    }
}
