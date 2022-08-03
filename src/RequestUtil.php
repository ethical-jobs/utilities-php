<?php

namespace EthicalJobs\Utilities;

use Illuminate\Http\Request;

class RequestUtil
{
    /**
     * Parses request select fields into an array
     *
     * @deprecated For some reason this
     *  a) used a global method (??) and
     *  b) thus binds this generic PHP package to Laravel
     * so deprecating now for next version to remove
     *
     * @return list<string>
     */
    public static function getSelectFields(): array
    {
        $grossGlobalMethod = request();
        assert($grossGlobalMethod instanceof Request);
        $select = $grossGlobalMethod->input('fields');
        if (isset($select) === true) {
            assert(is_string($select));
            $httpRequestSelectFields = explode(',', $select);

            if (str_contains($select, '*')) {
                $httpRequestSelectFields = ['*'];
            }
        }

        return $httpRequestSelectFields ?? [];
    }
}
