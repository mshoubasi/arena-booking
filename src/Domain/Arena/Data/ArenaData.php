<?php

namespace Domain\Arena\Data;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class ArenaData extends Data
{
    public function __construct(
        public readonly ?int $id,
        #[Exists('users', 'id')]
        public readonly int $user_id,
        public readonly string $name,
    ) {}

}