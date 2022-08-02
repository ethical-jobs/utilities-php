<?php

namespace EthicalJobs\Utilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiResources
{
    public const JOBS = 'jobs';
    public const ORGANISATIONS = 'organisations';
    public const USERS = 'users';
    public const MEDIA = 'media';
    public const INVOICES = 'invoices';
    public const TAXONOMIES = 'taxonomies';
    public const ROLES = 'roles';
    public const CREDITS = 'credits';

    /**
     * Returns model class from a REST resource identifier
     *
     * @param self::* $resource
     */
    public static function getModelFromResource(string $resource): string
    {
        if (!in_array($resource, static::getResources())) {
            return '';
        }

        return 'App\Models\\' . Str::studly(Str::singular($resource));
    }

    /**
     * Returns API resources
     *
     * @return list<self::*>
     */
    public static function getResources(): array
    {
        return [
            self::JOBS,
            self::ORGANISATIONS,
            self::USERS,
            self::MEDIA,
            self::INVOICES,
            self::TAXONOMIES,
            self::ROLES,
            self::CREDITS,
        ];
    }

    /**
     * Returns transformer class from a REST resource identifier
     *
     * @param self::* $resource
     */
    public static function getTransformerFromResource(string $resource): string
    {
        if (!in_array($resource, static::getResources())) {
            return '';
        }

        $resourceName = Str::studly(Str::singular($resource));

        return 'App\Transformers\\' . $resourceName . 's\\' . $resourceName . 'Transformer';
    }
}
