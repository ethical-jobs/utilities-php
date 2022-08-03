<?php

namespace Tests\Unit;

use EthicalJobs\Utilities\Arrays;
use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_test_for_keys_existing(): void
    {
        $array = [
            'apples' => 11,
            'oranges' => 23,
            'bananas' => 45,
        ];

        self::assertTrue(Arrays::hasKey($array, ['kiwis', 'avocados', 'apples']));
        self::assertFalse(Arrays::hasKey($array, ['kiwis', 'avocados', 'tomatoes']));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_expand_dot_notation_keys(): void
    {
        $array = [
            'food.fruit.apples' => 'manzana',
            'food.fruit.oranges' => 'naranja',
            'food.fruit.bananas' => 'plátano',
            'plants.trees.redgum' => 'árbol de redgum',
            'plants.trees.oak' => 'árbol de roble',
            'plants.scrub' => 'muchacho de negro',
        ];

        $expanded = Arrays::expandDotNotationKeys($array);
        $expected = [
            'food' => [
                'fruit' => [
                    'apples' => 'manzana',
                    'oranges' => 'naranja',
                    'bananas' => 'plátano',
                ],
            ],
            'plants' => [
                'trees' => [
                    'redgum' => 'árbol de redgum',
                    'oak' => 'árbol de roble',
                ],
                'scrub' => 'muchacho de negro',
            ],
        ];

        self::assertSame($expected, $expanded);
    }
}
