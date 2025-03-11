<?php

namespace Domain\Arena\Data;

use Domain\Arena\Enums\TimeslotStatus;
use Spatie\LaravelData\Attributes\FromRouteParameterProperty;
use Spatie\LaravelData\Data;

class TimeslotData extends Data
{
    public function __construct(
        public readonly ?int $id,
        #[FromRouteParameterProperty('arena')]
        public readonly ?int $arena_id,
        public readonly string $start_time,
        public readonly ?string $end_time,
        public readonly int $duration,
        public readonly TimeslotStatus $status = TimeslotStatus::Available,
    ) {
    }

}