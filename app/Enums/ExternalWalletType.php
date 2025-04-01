<?php

namespace App\Enums;

use App\Enums\Traits\HasValues;

enum ExternalWalletType: string
{
    use HasValues;

    case External = 'external';
    case System = 'system';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::External => 'External Source',
            self::System => 'Internal System',
        };
    }
}
