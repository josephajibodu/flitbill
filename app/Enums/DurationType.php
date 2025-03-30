<?php

namespace App\Enums;

enum DurationType: string
{
    case Hourly = "hourly";
    case Daily = "daily";
    case Weekly = "weekly";
    case BiWeekly = "bi-weekly";
    case Monthly = "monthly";
    case Quarterly = "quarterly";
    case FourMonths = "4-months";
    case Yearly = "yearly";
    case OneOff = "one-off";

    public function getLabel(): string
    {
        return match ($this) {
            self::Hourly => "hourly",
            self::Daily => "Daily",
            self::Weekly => "Weekly",
            self::BiWeekly => "2 Weeks",
            self::Monthly => "Monthly",
            self::Quarterly => "Quarterly",
            self::FourMonths => "4 Months",
            self::Yearly => "Yearly",
            self::OneOff => 'One off',
        };
    }
}
