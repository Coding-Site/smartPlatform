<?php

namespace App\Enums\OrderBook;

enum Status: string
{
    case New = 'new';
    case Current = 'current';
    case Complete = 'complete';
    case Finish = 'finish';
}
