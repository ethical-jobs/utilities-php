<?php

namespace EthicalJobs\Utilities;

class Money
{
    /**
     * @deprecated it's using floats, what else do I need to say
     */
    public static function withGst($value)
    {
        return self::gst($value) + $value;
    }

    /**
     * @deprecated it's using floats, what else do I need to say
     */
    public static function gst($value)
    {
        return ($value * 0.1);
    }

    /**
     * @deprecated it's using floats, what else do I need to say
     */
    static function format($value)
    {
        return '$' . number_format($value, 2, '.', ',');
    }
}
