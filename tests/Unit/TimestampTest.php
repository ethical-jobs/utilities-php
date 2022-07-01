<?php

namespace Tests\Unit\Utils;

use Carbon\Carbon;
use EthicalJobs\Utilities\Timestamp;
use Tests\TestCase;
use ValueError;

class TimestampTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function testCanConvertCarbonToMilliseconds()
    {
        $now = Carbon::now();

        $milliseconds = Carbon::now()->timestamp * 1000;

        $this->assertEquals($milliseconds, Timestamp::toMilliseconds($now));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_convert_date_string_to_milliseconds()
    {
        $dateString = '1983-09-28 17:55:00';

        $milliseconds = strtotime($dateString) * 1000;

        $this->assertEquals(Timestamp::toMilliseconds($dateString), $milliseconds);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_throws_error_for_empty_string()
    {
        $this->expectException(ValueError::class);

        Timestamp::toMilliseconds('');
    }

    /**
     * @test
     * @group Unit
     */
    public function it_throws_error_for_false()
    {
        $this->expectException(ValueError::class);

        Timestamp::toMilliseconds(false);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_throws_error_for_int0()
    {
        $this->expectException(ValueError::class);

        Timestamp::toMilliseconds(0);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_converts_unix_milliseconds_timestamp_to_carbon_instance()
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $this->assertInstanceOf(Carbon::class, Timestamp::fromMilliseconds($milliseconds));

        $this->assertEquals((Timestamp::fromMilliseconds($milliseconds))->timestamp, ($milliseconds / 1000));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_converts_milliseconds_timestamp_to_seconds_timestamp()
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $this->assertEquals(Timestamp::toSeconds($milliseconds), ($milliseconds / 1000));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_determine_if_a_timestamp_is_in_miliseconds()
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $this->assertTrue(Timestamp::isMilliseconds($milliseconds));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_parse_different_date_formats()
    {
        $now = Carbon::now();

        $this->assertEquals((string)Timestamp::parse('1983-09-28 17:55:00'), '1983-09-28 17:55:00');
        $this->assertEquals((string)Timestamp::parse(1465291482000), '2016-06-07 09:24:42');
        $this->assertEquals((string)Timestamp::parse($now), (string)$now);
    }
}
