<?php

namespace Domain\Booking\Enums;

enum BookingStatus: int
{
    case Pending = 0;
    case Confirmed = 1;
    case Expired = 2;
}
