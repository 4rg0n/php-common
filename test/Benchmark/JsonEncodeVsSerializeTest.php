<?php

namespace Argon\PhpCommon\Test\Benchmark;

use Argon\PhpCommon\Util\ArrayGenerator;
use Argon\PhpCommon\Util\Stopwatch;
use Argon\PhpCommon\Util\MemoryUsage;

/**
 * Class JsonEncodeVsSerializeTest
 *
 * @author  Dominic Roenicke <argonthechecker@gmail.com>
 * @package Argon\PhpCommon\Test\Benchmark
 */
class JsonEncodeVsSerializeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Stopwatch
     */
    private $stopwatch;

    /**
     * @var MemoryUsage
     */
    private $memoryUsage;

    /**
     * @var ArrayGenerator
     */
    private $arrayGenerator;

    /**
     * Test setup
     *
     * @return void
     */
    public function setUp()
    {
        $this->stopwatch = new Stopwatch();
        $this->memoryUsage = MemoryUsage::getInstance();
        $this->arrayGenerator = ArrayGenerator::getInstance();
    }

    /**
     * Benchmarks perfomance transforming different complex arrays with json_encode() vs serialize()
     *
     * @dataProvider arrayProvider
     *
     * @param string $complexity name of complexity
     * @param integer $length array length
     * @param integer $depth array depth
     *
     * @return void
     */
    public function testArrayTransformation($complexity, $length, $depth)
    {
        $array = $this->arrayGenerator->generate($length, $depth);

        $this->memoryUsage->capture('start-serialize');
        $this->stopwatch->start();
        $serialized = serialize($array);
        $this->memoryUsage->capture('end-serialize');
        $this->stopwatch->stop();

        $serializeTime = $this->stopwatch->getTime();

        $this->stopwatch->reset();

        $this->stopwatch->start();
        $this->memoryUsage->capture('start-json_encode');
        $json = json_encode($array);
        $this->memoryUsage->capture('end-json_encode');
        $this->stopwatch->stop();

        $jsonEncodeTime = $this->stopwatch->getTime();

        $this->stopwatch->reset();

        echo $complexity . '(length: ' . $length . '; depth: ' . $depth . "):\n";
        echo "serialize():\t" .
             $serializeTime . " ms\t"  .
             $this->memoryUsage->diff('start-serialize', 'end-serialize') . " KB\n";
        echo "json_decode():\t" .
             $jsonEncodeTime . " ms\t" .
             $this->memoryUsage->diff('start-json_encode', 'end-json_encode') . " KB\n\n";

        $this->memoryUsage->reset();
    }

    /**
     * Provides data for array length and depth
     *
     * @return array
     */
    public function arrayProvider()
    {
        return array(
            array('simple', 100, 0),
            array('long', 100000, 0),
            array('deep', 1, 100),
            array('long-deep', 100000, 100)
        );
    }
}
