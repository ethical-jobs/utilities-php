<?php

namespace EthicalJobs\Utilities;

use Illuminate\Support\Str;

class ApiResources
{
    /**
     * Returns model class from a REST resource identifier
     *
     * @param String $resource
     * @return String
     */
    public static function getModelFromResource($resource)
    {
        if (!in_array($resource, static::getResources())) {
            return '';
        }

        return 'App\Models\\' . Str::studly(Str::singular($resource));
    }

    /**
     * Returns API resources
     *
     * @return array
     */
    public static function getResources()
    {
        return [
            'jobs',
            'organisations',
            'users',
            'media',
            'invoices',
            'taxonomies',
            'roles',
            'credits',
        ];
    }

    /**
     * Returns transformer class from a REST resource identifier
     *
     * @param String $resource
     * @return String
     */
    public static function getTransformerFromResource($resource)
    {
        if (!in_array($resource, static::getResources())) {
            return '';
        }

        $resourceName = Str::studly(Str::singular($resource));

        return 'App\Transformers\\' . $resourceName . 's\\' . $resourceName . 'Transformer';
    }
}
