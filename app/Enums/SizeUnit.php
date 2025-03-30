<?php

namespace App\Enums;

enum SizeUnit: string
{
    case MB = "mb";
    case GB = "gb";
    case TB = "tb";
    case PB = "pb";

    public function getLabel(): string
    {
        return match ($this) {
            self::MB => "Megabyte",
            self::GB => "Gigabyte",
            self::TB => "Terabyte",
            self::PB => "Petabyte",
        };
    }
}
