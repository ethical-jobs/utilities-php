<?php

namespace EthicalJobs\Utilities;

/**
 * Money utility class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class Money
{
    /**
     * Adds GST to a value
     *
     * @return Integer
     */
    public static function withGst($value)
    {
        return self::gst($value) + $value;
    }

    /**
     * Returns the GST of a value
     *
     * @return Integer
     */
    public static function gst($value)
    {
        return ($value * 0.1);
    }

    /**
     * Format a money field
     *
     * @return String
     */
    static function format($value)
    {
        return '$' . number_format($value, 2, '.', ',');
    }
}
