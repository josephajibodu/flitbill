<?php

namespace App\Enums;


use App\Enums\Traits\HasValues;

enum CableProvider: string
{
    use HasValues;

    case Startimes = 'startimes';
    case GoTV = 'gotv';
    case DSTV = 'dstv';
    case ShowMax = 'showmax';
}
