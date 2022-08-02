<?php

namespace EthicalJobs\Utilities;

class Money
{
    /**
     * @deprecated it's using floats, what else do I need to say
     */
    public static function withGst(int|float $value): float
    {
        return self::gst($value) + $value;
    }

    /**
     * @deprecated it's using floats, what else do I need to say
     */
    public static function gst(int|float $value): float
    {
        return ($value * 0.1);
    }

    /**
     * @deprecated it's using floats, what else do I need to say
     */
    static function format(float $value): string
    {
        return '$' . number_format($value, 2, '.', ',');
    }
}
