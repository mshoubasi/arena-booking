<?php

namespace Domain\Arena\Builders;

use Domain\Arena\Enums\TimeslotStatus;
use Illuminate\Database\Eloquent\Builder;

class TimeslotBuilder extends Builder
{
    public function overlaps($startTime, $endTime): bool
    {
        return $this->where(function (Builder $query) use ($endTime, $startTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                ->orWhereBetween('end_time', [$startTime, $endTime])
                ->orWhere(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $startTime)
                        ->where('end_time', '>', $endTime);
                });
        })->exists();
    }

    public function available(): bool
    {
        return $this->where('status', TimeslotStatus::Available)->exists();
    }

    public function booked(): void
    {
        $this->model->status = TimeslotStatus::Booked;
        $this->model->save();
    }

    public function reserved(): void
    {
        $this->model->status = TimeslotStatus::Reserved;
        $this->model->save();
    }
}