<?php

namespace Tests\Unit;

use EthicalJobs\Utilities\ApiResources;
use Tests\TestCase;

class ApiResourcesTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_return_a_model_class_from_a_REST_resource(): void
    {
        self::assertSame(
            'App\Models\Organisation',
            ApiResources::getModelFromResource('organisations')
        );

        self::assertSame(
            'App\Models\Invoice',
            ApiResources::getModelFromResource('invoices')
        );

        self::assertSame(
            'App\Models\Job',
            ApiResources::getModelFromResource('jobs')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_return_a_transformer_class_from_a_REST_resource(): void
    {
        self::assertSame(
            'App\Transformers\Organisations\OrganisationTransformer',
            ApiResources::getTransformerFromResource('organisations')
        );

        self::assertSame(
            'App\Transformers\Invoices\InvoiceTransformer',
            ApiResources::getTransformerFromResource('invoices')
        );

        self::assertSame(
            'App\Transformers\Jobs\JobTransformer',
            ApiResources::getTransformerFromResource('jobs')
        );
    }
}
