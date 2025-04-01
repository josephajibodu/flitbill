<?php

namespace App\Enums;


use App\Enums\Traits\HasValues;

enum WalletTransactionStatus: string
{
    use HasValues;

    case Pending = 'pending';
    case Committed = 'committed';
}