<?php

namespace Domain\Booking\Data;

use Carbon\Carbon;
use Domain\Booking\Enums\BookingStatus;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Data;

class BookingData extends Data
{
    public function __construct(
        public readonly ?int $id,
        #[FromRouteParameterProperty('timeslot')]
        public readonly ?int $time_slot_id,
        public readonly int $user_id,
        public readonly ?BookingStatus $status = BookingStatus::Pending,
        public readonly ?string $expires_at = null,
    ) {
    }
}