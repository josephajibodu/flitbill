<?php

namespace App\Enums;


use App\Enums\Traits\HasValues;

enum ElectricityProvider: string
{
    use HasValues;

    case IKEDC = 'ikeja-electric';
    case EKEDC = 'eko-electric';
    case KEDCO = 'kano-electric';
    case PHED = 'portharcourt-electric';
    case JED = 'jos-electric';
    case IBEDC = 'ibadan-electric';
    case KAEDCO = 'kaduna-electric';
    case AEDC = 'abuja-electric';
    case EEDC = 'enugu-electric';
    case BEDC = 'benin-electric';
    case ABA = 'aba-electric';
    case YEDC = 'yola-electric';
}
