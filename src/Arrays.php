<?php

namespace EthicalJobs\Utilities;

/**
 * General Array helper class
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class Arrays
{
    /**
     * Expands arrays with keys that have dot notation
     *
     * @param array $array
     *
     * @return array
     */
    public static function expandDotNotationKeys(Array $array)
    {
        $result = [];

        foreach ($array as $key => $value) {
            array_set($result, $key, $value);
        }

        return $result;
    }

    /**
     * Convert from an object to an array including private and protected members
     *
     * @see url http://stackoverflow.com/questions/2476876/how-do-i-convert-an-object-to-an-array
     *
     * @return array
     */
    public static function objectToArray($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }

        return array_map('objectToArray', (array)$object);
    }

    /**
     * Returns true if $array has a key in $keys
     *
     * @param array $array
     * @param array $keys
     * @return bool
     */
    public static function hasKey(Array $array, Array $keys)
    {
        foreach ($array as $key => $value) {
            if (in_array($key, $keys)) {
                return true;
            }
        }

        return false;
    }
}
