<?php /** @noinspection PhpDeprecationInspection */

namespace EthicalJobs\Utilities;

use Carbon\Carbon;
use Exception;
use JetBrains\PhpStorm\Pure;

use function bcdiv;

class Timestamp
{
    public static function toMilliseconds($value): string
    {
        $isString = is_string($value);
        $isNumeric = is_numeric($value);

        if ($value instanceof \Carbon\Carbon) {
            return self::toMillisecondsFromCarbon($value);
        }
        if ($isString && !$isNumeric) {
            return self::toMillisecondsFromDateString($value);
        }
        if ($isString && $isNumeric) {
            return \bcmul($value, 1000);
        }

        throw new \ValueError('Not Carbon, numeric or string.');
    }

    public static function toMillisecondsFromCarbon(Carbon $value): string
    {
        return \bcmul($value->timestamp, 1000);
    }

    public static function toMillisecondsFromDateString($value): string
    {
        if ($value === '') {
            throw new \ValueError('Not a valid datestring or numeric string.');
        }
        return \bcmul(Carbon::parse($value)->timestamp, 1000);
    }

    public static function isExpired(Carbon $value): bool
    {
        return $value->lt(Carbon::now());
    }

    public static function parse($timestamp = null): Carbon
    {
        if (static::isMilliseconds($timestamp)) { // phpcs:ignore
            return static::fromMilliseconds($timestamp);
        }

        if ($timestamp instanceof Carbon) {
            return $timestamp;
        }

        return Carbon::parse($timestamp);
    }

    #[Pure]
    public static function isARecentTimestampInMilliseconds(string $potential): bool
    {
        return is_numeric($potential) && strlen((string)$potential) === 13;
    }

    /**
     * @deprecated a bit silly, given 1000-129999999999 would fail
     *
     */
    public static function isMilliseconds(string $timestamp): bool
    {
        $isNumeric = is_numeric($timestamp);
        $isThirteenOrMoreDigits = strlen( $timestamp) >= 12;

        return $isNumeric && $isThirteenOrMoreDigits;
    }

    public static function fromMilliseconds(string $timestamp): Carbon
    {
        assert(is_numeric($timestamp), 'Must provide a numeric string');

        return Carbon::createFromTimestamp(self::toSeconds($timestamp));
    }

    public static function toSeconds(string $timestamp): string
    {
        assert(is_numeric($timestamp), 'Must provide a numeric string');

        return bcdiv($timestamp, 1000);
    }
}
