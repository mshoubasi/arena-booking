<?php

namespace Domain\Arena\Models;

use Domain\Arena\Builders\TimeslotBuilder;
use Domain\Arena\Enums\TimeslotStatus;
use Domain\Booking\Models\Booking;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Timeslot extends BaseModel
{
    public function arena(): BelongsTo
    {
        return $this->belongsTo(Arena::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new TimeSlotBuilder($query);
    }

    protected function casts(): array
    {
        return [
            'status' => TimeslotStatus::class,
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
