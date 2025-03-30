<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;

enum NetworkProvider: string
{
    use HasValues;

    case MTN = 'mtn';
    case GLO = 'glo';
    case AIRTEL = 'airtel';
    case _9MOBILE = '9mobile';
}
