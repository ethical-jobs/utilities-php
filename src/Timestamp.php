<?php /** @noinspection PhpDeprecationInspection */

namespace EthicalJobs\Utilities;

use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

use function bcmul;
use function bcdiv;

class Timestamp
{
    /**
     * @param mixed $value
     * @return numeric-string
     */
    public static function toMilliseconds(mixed $value): string
    {
        if ($value instanceof Carbon) {
            return self::toMillisecondsFromCarbon($value);
        }
        if (is_string($value)) {
            if (is_numeric($value)) {
                return bcmul($value, '1000');
            }
            return self::toMillisecondsFromDateString($value);
        }

        throw new \ValueError('Not Carbon, numeric or string.');
    }

    /**
     * @param \Carbon\Carbon $value
     * @return numeric-string
     */
    public static function toMillisecondsFromCarbon(Carbon $value): string
    {
        return bcmul((string) $value->timestamp, '1000');
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
        return bcmul((string) Carbon::parse($value)->timestamp, '1000');
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
        $isThirteenOrMoreDigits = strlen($timestamp) >= 12;

        return $isNumeric && $isThirteenOrMoreDigits;
    }

    /** @param numeric-string $timestamp */
    public static function fromMilliseconds(string $timestamp): Carbon
    {
        assert(is_numeric($timestamp), 'Must provide a numeric string');

        /**
         * {@see Carbon::createFromTimestamp()} will work just fine if provided a numeric string, but in older versions
         * its type annotations specify that it requires an int and nothing else. So we're going to sneakily declare
         * that our numeric string is actually an int.
         *
         * @var int $secondsAsInt
         */
        $secondsAsInt = self::toSeconds($timestamp);

        return Carbon::createFromTimestamp($secondsAsInt);
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
