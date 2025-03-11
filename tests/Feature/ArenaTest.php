<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Domain\Arena\Data\ArenaData;
use Domain\Arena\Data\TimeslotData;
use Domain\Arena\Enums\TimeslotStatus;
use Domain\Arena\Models\Arena;
use Domain\Shared\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArenaTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_arena()
    {
        $user = User::factory()->create();
        $arenaData = new ArenaData(
            id: null,
            user_id: $user->id,
            name: 'Test Arena',
        );

        $response = $this->postJson('/api/arena', $arenaData->toArray());

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'user_id',
            ]);

        $this->assertDatabaseHas('arenas', [
            'name' => 'Test Arena',
            'user_id' => $user->id,
        ]);
    }

    public function test_create_time_slot()
    {
        $user = User::factory()->create();
        $arena = Arena::factory()->for($user)->create();
        $startTime = Carbon::parse('2023-10-01 10:00:00');
        $duration = 60;

        $timeSlotData = new TimeslotData(
            id: null,
            arena_id: $arena->id,
            start_time: $startTime->toDateTimeString(),
            end_time: null,
            duration: $duration,
            status: TimeslotStatus::Available
        );

        $response = $this->postJson("/api/arena/{$arena->id}/timeslot", $timeSlotData->toArray());

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'arena_id',
                'start_time',
                'end_time',
                'duration',
                'status',
            ]);

        $this->assertDatabaseHas('time_slots', [
            'arena_id' => $arena->id,
            'start_time' => $startTime->toDateTimeString(),
            'end_time' => $startTime->copy()->addMinutes($duration)->toDateTimeString(),
            'duration' => $duration,
            'status' => 0,
        ]);
    }
}