<?php

namespace Domain\Booking\Models;

use Domain\Arena\Models\Timeslot;
use Domain\Booking\Builders\BookingBuilder;
use Domain\Booking\Enums\BookingStatus;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends BaseModel
{
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new BookingBuilder($query);
    }

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'status' => BookingStatus::class,
        ];
    }
}
