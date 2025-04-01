<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;

enum WalletType: string
{
    use HasValues;

    case Main = 'main';
    case Bonus = 'bonus';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Main => 'Main Balance',
            self::Bonus => 'Bonus Balance',
        };
    }
}
