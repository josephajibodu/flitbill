<?php

namespace App\Enums;

enum TransactionType: string
{
    case Airtime = 'airtime';
    case DataTopup = 'data-topup';
    case Cable = 'cable';
    case Electricity = 'electricity';
}
