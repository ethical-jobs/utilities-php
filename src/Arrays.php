<?php

namespace EthicalJobs\Utilities;

use Illuminate\Support\Arr;

class Arrays
{
    /**
     * Expands arrays with keys that have dot notation
     *
     * @param array<string, mixed> $array
     * @return array<string, mixed>
     */
    public static function expandDotNotationKeys(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            Arr::set($result, $key, $value);
        }

        return $result;
    }

    /**
     * Recursively convert from an object to an array including private and protected members
     *
     * @see https://stackoverflow.com/questions/2476876/how-do-i-convert-an-object-to-an-array
     *
     * @template T
     * @param T $object
     * @return (T is object ? array<string, mixed> : T)
     */
    public static function objectToArray(mixed $object): mixed
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }

        return array_map([self::class, 'objectToArray'], (array)$object);
    }

    /**
     * Returns true if $array has any key in $keys
     *
     * @template T of int|string
     * @param array<T, mixed> $array
     * @param list<T> $keys
     * @return bool
     */
    public static function hasKey(array $array, array $keys): bool
    {
        foreach ($array as $key => $value) {
            if (in_array($key, $keys)) {
                return true;
            }
        }

        return false;
    }
}
