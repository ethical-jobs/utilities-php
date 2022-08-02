<?php

namespace Tests\Unit;

use Carbon\Carbon;
use EthicalJobs\Utilities\Dates;
use Tests\Fixtures\Person;
use Tests\TestCase;

class DatesTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_returns_false_when_checking_for_recent_and_date_is_null(): void
    {
        $model = new Person();

        $model->created_at = null;

        self::assertFalse(Dates::wasCreatedRecently($model));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_check_if_a_model_was_created_recently(): void
    {
        $model = new Person();

        $model->created_at = Carbon::now();
        self::assertTrue(Dates::wasCreatedRecently($model));

        $model->created_at = Carbon::now()->subMinute();
        self::assertTrue(Dates::wasCreatedRecently($model));

        $model->created_at = Carbon::now()->subMinute()->subSeconds(55);
        self::assertTrue(Dates::wasCreatedRecently($model));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_check_if_a_model_was_NOT_created_recently(): void
    {
        $model = new Person();

        $model->created_at = Carbon::now()->addMinutes(5);
        self::assertFalse(Dates::wasCreatedRecently($model));

        $model->created_at = Carbon::now()->subMinutes(5);
        self::assertFalse(Dates::wasCreatedRecently($model));
    }
}
