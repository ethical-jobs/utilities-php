<?php

namespace EthicalJobs\Utilities;

use Exception;

class RequestUtil
{
    /**
     * Parses request select fields into an array
     *
     * @deprecated For some reason this
     *  a) used a global method (??) and
     *  b) thus binds this generic PHP package to Laravel
     * so deprecating now for next version to remove
     */
    public static function getSelectFields(): array
    {
        $grossGlobalMethod = request();
        $select = $grossGlobalMethod->input('fields');
        if (isset($select) === true) {
            $httpRequestSelectFields = explode(',', $select);

            if (str_contains($select, '*')) {
                $httpRequestSelectFields = ['*'];
            }
        }

        return $httpRequestSelectFields ?? [];
    }
}
