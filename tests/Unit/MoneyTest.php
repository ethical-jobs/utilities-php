<?php
declare(strict_types=1);

namespace Tests\Unit;

use EthicalJobs\Utilities\Money;
use Tests\TestCase;


class MoneyTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function testCanCalculateGstInPracticalUsecase(): void
    {
        self::markTestSkipped('GST infers a float into latter calculations causing a non-insignificant error beyond a slight rounding issue (hundreds of dollars)');
        $productPrice = 99.99;
        $gst = Money::gst($productPrice);
        $gstShouldBe = 9.99;

        $productCount = 99457;
        $companyGstTotal = $gst * $productCount;
        $companyGstTotalShouldBe = 993575.43;

        self::assertSame($companyGstTotalShouldBe,$companyGstTotal);
    }

    public function testCanAccumulateGstAndStoreInArray(): void
    {
        self::markTestSkipped("Don't use floats");

        $accumulatedGST = 0.0;
        $productPrice = 10;
        // Total accumulation will be exactly 10, because 10% of 10 products priced at $10 is $10 (eg $0.1 times 10 of 'em)
        for ($i = 0; $i < 10; $i++) {
            $accumulatedGST += Money::gst($productPrice);
        }

        $arrayStore = ['value' => $accumulatedGST];

        self::assertTrue($arrayStore['value'] === 10, 'The accumulated GST value of '.$arrayStore['value'].' doesn\'t match 10');
    }

    /**
     * @test
     * @group Unit
     */
    public function testCanConvertSeveralProductsExGSTPriceIntoWithGst(): void
    {
        self::markTestSkipped('fails');
        $productValue = 189.09;
        $productCount = 100;

        $formula = $productValue + ($productValue * 0.1);
        $computedFormulaResult = 207.999;
        $actualFormula = Money::withGST($productValue);
        $emulatedFormulaMatchesFunction = $formula === $actualFormula;
        self::assertTrue($emulatedFormulaMatchesFunction, 'the represented formula (p + (p*0.1)) is incorrect');

        $computedMultiple = 20799.9;
        $formulaMultiple = $computedFormulaResult * $productCount;
        self::assertTrue($computedMultiple === $formulaMultiple, 'the pre-calculated multiple vs actual is incorrect');
        self::assertSame($computedMultiple, Money::withGst($productValue) * 100, 'the precalculated multiple doesnt match the withGst method\'s multiple');
    }

    /**
     * @deprecated - favour the above equivalents until floats removed
     * @test
     * @group Unit
     */
    public function it_can_calculate_gst(): void
    {
        self::assertEquals((1000 * 0.1), Money::gst(1000));

        self::assertEquals((198.87 * 0.1), Money::gst(198.87));
    }

    /**
     * @deprecated - favour the above equivalents until floats removed
     * @test
     * @group Unit
     */
    public function it_can_calculate_value_with_gst(): void
    {
        self::assertEquals((1000+(1000 * 0.1)), Money::withGst(1000));

        self::assertEquals((198.87+(198.87 * 0.1)), Money::withGst(198.87));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_format_numbers_to_money(): void
    {
        self::assertEquals('$100.00', Money::format(100));

        self::assertEquals('$1,000.00', Money::format(1000));

        self::assertEquals('$10,000.00', Money::format(10000));

        self::assertEquals('$1,000,000.00', Money::format(1000000));

        self::assertEquals('$150.57', Money::format(150.57));

        self::assertEquals('$150.60', Money::format(150.598777));

        self::assertEquals('$1,050.49', Money::format(1050.48779979));
    }
}
