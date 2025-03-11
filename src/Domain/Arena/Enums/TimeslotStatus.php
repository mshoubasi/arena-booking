<?php

namespace Domain\Arena\Enums;

enum TimeslotStatus: int
{
    case Available = 0;
    case Booked = 1;
    case Reserved = 2;
}
