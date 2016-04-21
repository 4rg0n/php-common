<?php

namespace Argon\PhpCommon\Test\Util;

use Argon\PhpCommon\Util\ArrayGenerator;

/**
 * Class ArrayGeneratorTest
 *
 * @package Argon\PhpCommon\Test\Util
 * @author Dominic Roenicke <argonthechecker@gmail.com>
 */
class ArrayGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests generation of arrays in various lengths and depths
     *
     * @dataProvider positiveArrayProvider
     *
     * @param integer $length array length
     * @param integer $depth array depth
     *
     * @return void
     */
    public function testArrayGeneration($length, $depth)
    {
        $arrayGenerator = ArrayGenerator::getInstance();

        $array = $arrayGenerator->generate($length, $depth);

        self::assertCount($length, $array);
        self::assertEquals($depth, $this->getArrayDepth($array));
    }

    /**
     * Tests generation of arrays with invalid length and depth values
     *
     * @dataProvider negativeArrayProvider
     * @expectedException Argon\PhpCommon\Util\Exception\UtilException
     *
     * @param integer $length array length
     * @param integer $depth array depth
     *
     * @return void
     */
    public function testNegativeArrayGeneration($length, $depth)
    {
        $arrayGenerator = ArrayGenerator::getInstance();

        $arrayGenerator->generate($length, $depth);
    }

    /**
     * Provides non functional data for array length and depth
     *
     * @return array test data
     */
    public function negativeArrayProvider()
    {
        return array(
            array(0, 0),
            array(0, 1),
            array(-1, 1),
            array(1, -1),
            array(-1, -1)
        );
    }

    /**
     * Provides functional data for array length and depth
     *
     * @return array test data
     */
    public function positiveArrayProvider()
    {
        return array(
            array(10, 0),
            array(10, 10),
            array(1, 10)
        );
    }

    /**
     * Returns the depth of an array
     *
     * @param array $array array to get depth from
     *
     * @return integer array depth
     */
    private function getArrayDepth(array $array)
    {
        $arrayDepth = 0;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->getArrayDepth($value) + 1;

                if ($depth > $arrayDepth) {
                    $arrayDepth = $depth;
                }
            }
        }

        return $arrayDepth;
    }
}
