<?php

namespace Domain\Booking\Builders;

use Domain\Arena\Enums\TimeslotStatus;
use Domain\Booking\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Builder;

class BookingBuilder extends Builder
{
    public function confirmed(): void
    {
        $this->model->status = BookingStatus::Confirmed;
        $this->model->save();
    }

    public function pending(): bool
    {
        return $this->where('status', BookingStatus::Pending)
            ->where('expires_at', '>', now())->exists();
    }

    public function releaseExpired(): int
    {
        return $this->where('status', BookingStatus::Pending)
            ->where('expires_at', '<=', now())
            ->update(['status' => BookingStatus::Expired]);
    }
}