<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Canceled = 'canceled';
    case Waiting = 'waiting';
    case Preparation = 'preparation';
    case Ready = 'ready';
    case Delivered = 'delivered';
}
