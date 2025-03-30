<?php


use App\Enums\DurationType;
use App\Enums\SizeUnit;
use Illuminate\Support\Str;

function detectDurationType(string $name): ?DurationType
{
    $name = strtolower($name);
    $duration = detectDuration($name);

    if (Str::contains($name, 'day')) {
        if ($duration > 180) return DurationType::Yearly;
        else if ($duration > 90) return DurationType::Quarterly;
        else if ($duration > 14) return DurationType::Monthly;
        else if ($duration > 4) return DurationType::Weekly;
        else return DurationType::Daily;
    } elseif (Str::contains($name, 'week')) {
        return DurationType::Weekly;
    } elseif (Str::contains($name, 'month')) {
        return DurationType::Monthly;
    } elseif (Str::contains($name, 'year')) {
        return DurationType::Yearly;
    } elseif (Str::contains($name, 'oneoff')) {
        return DurationType::OneOff;
    } else {
        return null;
    }
}

function detectDuration(string $name): int
{
    if (preg_match('/(\d+)[-\s]?(day|week|month|hours|hrs|oneoff)/i', $name, $matches)) {
        return (int) $matches[1];
    }
    return 1;
}

function detectSize(string $name): ?float
{
    if (preg_match('/(\d+(\.\d+)?)\s?(GB|MB|TB)/i', $name, $matches)) {
        return (float) $matches[1];
    }
    return null;
}

function detectSizeUnit(string $name): ?SizeUnit
{
    if (Str::contains($name, 'GB')) {
        return SizeUnit::GB;
    } elseif (Str::contains($name, 'MB')) {
        return SizeUnit::MB;
    } elseif (Str::contains($name, 'TB')) {
        return SizeUnit::TB;
    } else {
        return null;
    }
}

function detectAdditionalPart(string $name): ?string
{
    // Find the last occurrence of `+` outside parentheses
    preg_match_all('/\+/i', $name, $allMatches, PREG_OFFSET_CAPTURE);

    if (!empty($allMatches[0])) {
        foreach (array_reverse($allMatches[0]) as $match) {
            $plusIndex = $match[1];

            // Ensure `+` is not inside parentheses
            if (!isInsideParentheses($name, $plusIndex)) {
                return trim(substr($name, $plusIndex + 1));
            }
        }
    }

    return null;
}

/**
 * Check if a given index is inside parentheses.
 */
function isInsideParentheses(string $text, int $index): bool
{
    $openCount = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        if ($text[$i] === '(') {
            $openCount++;
        } elseif ($text[$i] === ')') {
            $openCount--;
        }

        if ($i === $index) {
            return $openCount > 0;
        }
    }
    return false;
}