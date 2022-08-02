<?php /** @noinspection PhpDeprecationInspection */

namespace EthicalJobs\Utilities;

use Carbon\Carbon;
use Exception;
use JetBrains\PhpStorm\Pure;

use function bcdiv;

class Timestamp
{
    /**
     * @param Carbon|numeric-string|string $value
     * @return numeric-string
     */
    public static function toMilliseconds($value): string
    {
        $isString = is_string($value);
        $isNumeric = is_numeric($value);

        if ($value instanceof Carbon) {
            return self::toMillisecondsFromCarbon($value);
        }
        if ($isString && !$isNumeric) {
            return self::toMillisecondsFromDateString($value);
        }
        if ($isString && $isNumeric) {
            return \bcmul($value, '1000');
        }

        throw new \ValueError('Not Carbon, numeric or string.');
    }

    /**
     * @param \Carbon\Carbon $value
     * @return numeric-string
     */
    public static function toMillisecondsFromCarbon(Carbon $value): string
    {
        return \bcmul((string) $value->timestamp, '1000');
    }

    /**
     * @param string $value
     * @return numeric-string
     */
    public static function toMillisecondsFromDateString($value): string
    {
        if ($value === '') {
            throw new \ValueError('Not a valid datestring or numeric string.');
        }
        return \bcmul((string) Carbon::parse($value)->timestamp, '1000');
    }

    public static function isExpired(Carbon $value): bool
    {
        return $value->lt(Carbon::now());
    }

    /**
     * @param Carbon|string|null $timestamp
     */
    public static function parse($timestamp = null): Carbon
    {
        if (is_string($timestamp) && is_numeric($timestamp) && static::isMilliseconds($timestamp)) { // phpcs:ignore
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

    /** @param numeric-string $timestamp */
    public static function fromMilliseconds(string $timestamp): Carbon
    {
        assert(is_numeric($timestamp), 'Must provide a numeric string');

        return Carbon::createFromTimestamp(self::toSeconds($timestamp));
    }

    /**
     * @param numeric-string $timestamp
     * @return numeric-string
     */
    public static function toSeconds(string $timestamp): string
    {
        assert(is_numeric($timestamp), 'Must provide a numeric string');

        return bcdiv($timestamp, '1000');
    }
}
