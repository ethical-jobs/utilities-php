<?php

namespace Tests\Unit;

use Carbon\Carbon;
use EthicalJobs\Utilities\Timestamp;
use PHPUnit\Framework\TestCase;
use ValueError;

class TimestampTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function testCanConvertCarbonToMilliseconds(): void
    {
        $now = Carbon::now();

        $milliseconds = ((float) Carbon::now()->timestamp) * 1000;

        self::assertEquals($milliseconds, Timestamp::toMilliseconds($now));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_convert_date_string_to_milliseconds(): void
    {
        $dateString = '1983-09-28 17:55:00';

        $milliseconds = strtotime($dateString) * 1000;

        self::assertEquals($milliseconds, Timestamp::toMilliseconds($dateString));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_throws_error_for_empty_string(): void
    {
        $this->expectException(ValueError::class);

        Timestamp::toMilliseconds('');
    }

    /**
     * @test
     * @group Unit
     */
    public function it_throws_error_for_false(): void
    {
        $this->expectException(ValueError::class);

        Timestamp::toMilliseconds(false);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_throws_error_for_int0(): void
    {
        $this->expectException(ValueError::class);

        Timestamp::toMilliseconds(0);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_converts_unix_milliseconds_timestamp_to_carbon_instance(): void
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        $date = Timestamp::fromMilliseconds((string) $milliseconds);

        self::assertEquals(($milliseconds / 1000), $date->timestamp);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_converts_milliseconds_timestamp_to_seconds_timestamp(): void
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        self::assertEquals(($milliseconds / 1000), Timestamp::toSeconds((string) $milliseconds));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_determine_if_a_timestamp_is_in_milliseconds(): void
    {
        $milliseconds = strtotime('1983-09-28 17:55:00') * 1000;

        self::assertTrue(Timestamp::isMilliseconds((string) $milliseconds));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_parse_different_date_formats(): void
    {
        $now = Carbon::now();

        self::assertEquals('1983-09-28 17:55:00', (string) Timestamp::parse('1983-09-28 17:55:00'));
        self::assertEquals('2016-06-07 09:24:42', (string) Timestamp::parse('1465291482000'));
        self::assertEquals((string) $now, (string) Timestamp::parse($now));
    }
}
