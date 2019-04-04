<?php

namespace EthicalJobs\Utilities;

use Carbon\Carbon;

/**
 * Timestamp utility class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class Timestamp
{
    /**
     * Converts carbon instance to milliseconds
     *
     * @param Carbon|string|null $value PHP unix timestamp (seconds)
     * @return float|int|null
     */
    public static function toMilliseconds($value = null)
    {
        if (!$value) {
            return null;
        }

        if (!$value instanceof Carbon) {
            $value = Carbon::parse($value); // attempt to parse it
        }

        return (int)$value->timestamp * 1000;
    }

    /**
     * Determines if a date is past
     *
     * @param Carbon|string|integer $date
     * @return boolean
     */
    public static function isExpired($date = null)
    {
        return (bool)self::parse($date)->lte(Carbon::now());
    }

    /**
     * Attempts to parse a date into Carbon
     *
     * @param Carbon|string|integer $timestamp
     * @return Carbon
     */
    public static function parse($timestamp = null)
    {
        if (static::isMilliseconds($timestamp)) {
            return static::fromMilliseconds($timestamp);
        }

        if ($timestamp instanceof Carbon) {
            return $timestamp;
        }

        return Carbon::parse($timestamp);
    }

    /**
     * Truthy for checking if a timestamp is in milliseconds
     *
     * @param Carbon|string|integer|null $timestamp Javascript unix timestamp (milliseconds)
     * @return Bool
     */
    public static function isMilliseconds($timestamp = null)
    {
        if (!$timestamp || $timestamp instanceof Carbon) {
            return false;
        }

        if (is_numeric($timestamp) && strlen((string)$timestamp) >= 12) {
            return true;
        }

        return false;
    }

    /**
     * Converts timestamp to carbon instance
     *
     * @param Carbon|null $timestamp
     * @return Carbon|null
     */
    public static function fromMilliseconds($timestamp = null)
    {
        if (!$timestamp) {
            return null;
        }

        return Carbon::createFromTimestamp(self::toSeconds($timestamp));
    }

    /**
     * Converts timestamp to seconds
     *
     * @param string|integer $timestamp Javascript unix timestamp (miniseconds)
     * @return float|int|null
     */
    public static function toSeconds($timestamp = null)
    {
        if (!$timestamp) {
            return null;
        }

        return (int)$timestamp / 1000;
    }
}
