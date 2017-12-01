<?php
declare(strict_types=1);
/**
 * This file is part of the Set package.
 * For the full copyright information please view the LICENCE file that was
 * distributed with this package.
 *
 * @copyright Simon Deeley 2017
 */

namespace simondeeley\Tests;

use simondeeley\Set;
use PHPUnit\Framework\TestCase;

/**
 * Test units for Set object
 *
 * @author Simon Deeley <s.deeley@icloud.com>
 */
final class SetTest extends TestCase
{
    /**
     * Test should show equality between two equal sets
     *
     * @test
     * @dataProvider equalSetData
     * @param array $setOne - items to instantiate set one
     * @param array $setTwo - items to instantiate set two
     * @return void
     */
    final public function shouldShowEqualityBetweenTwoEqualSets(array $setOne, array $setTwo): void
    {
        $one = $this->getMockBuilder(Set::class)
            ->setConstructorArgs($setOne)
            ->getMock()
        ;

        $two = $this->getMockBuilder(Set::class)
            ->setConstructorArgs($setTwo)
            ->getMock()
        ;

        $this->$this->assertTrue($one->equals($two));
    }

    /**
     * Test should show inequality between two unequal sets
     *
     * @test
     * @dataProvider unequalSetData
     * @param array $setOne - items to instantiate set one
     * @param array $setTwo - items to instantiate set two
     * @return void
     */
    final public function shouldShowInequalityBetweenTwoUnequalSets(array $setOne, array $setTwo): void
    {
        $one = $this->getMockBuilder(Set::class)
            ->setConstructorArgs($setOne)
            ->getMock()
        ;

        $two = $this->getMockBuilder(Set::class)
            ->setConstructorArgs($setTwo)
            ->getMock()
        ;

        $this->$this->assertFalse($one->equals($two));
    }

    /**
     * Data provider§
     *
     * @return array
     */
    final public function equalSetData(): array
    {
        return [
            [[ 1, 2, 3 ], [ 1, 2, 3 ]],
            [[ 1, 2, 3 ], [ 3, 2, 1 ]],
            [[ 1, 2, 3 ], [ 1, 2, 2, 3 ]],
            [[ 'foo', 'bar '], [ 'bar', 'foo' ]],
            [[ true ], [ false ]],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    final public function unequalSetData(): array
    {
        return [
            [[ 1, 2, 3 ], [ 1, 2, 2 ]],
            [[ 1, 2, 3 ], [ 1, 2, 3, 4 ]],
            [[ 1, 2, 3 ], [ 1, 2 ]],
            [[ 'foo' ], [ 'bar' ]],
            [[ true ], [ false ]],
        ];
    }
}
