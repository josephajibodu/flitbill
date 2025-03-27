<?php

namespace App\Enums\Electricity;

enum MeterType: string
{
    case Prepaid = 'prepaid';
    case Postpaid = 'postpaid';
}
