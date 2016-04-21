<?php

namespace Argon\PhpCommon\Util;

use Argon\PhpCommon\Util\Exception\UtilException;

/**
 * Class ArrayGenerator
 *
 * @author  Dominic Roenicke <argonthechecker@gmail.com>
 * @package Argon\PhpCommon\Util
 */
class ArrayGenerator
{
    /**
     * @var ArrayGenerator
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     * Saves the instance in static class variable.
     *
     * @return ArrayGenerator
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * Generates an array via given length and depth
     *
     * @param int $length number of entries in the array
     * @param int $depth number of interleaved arrays
     *
     * @return array generated array
     *
     * @throws UtilException when length <= 0
     * @throws UtilException when depth < 0
     */
    public function generate($length = 10, $depth = 10)
    {
        if ($length <= 0) {
            throw new UtilException('Length must be 1 or greater.');
        }

        if ($depth < 0) {
            throw new UtilException('Depth must be 0 or greater.');
        }

        $depthArray = $this->generateDeep($depth);
        $array = array();

        for ($i = 0; $i < $length; $i++) {
            $array[] = $depthArray;
        }

        return $array;
    }

    /**
     * Singelton classes are not allowed to be instanciated directly
     */
    protected function __construct()
    {
        // Nothing to do here
    }

    /**
     * Generates an array with given depth.
     * When depth is 0, null will be returned.
     *
     * @param int $depth number of interleaved arrays
     *
     * @return array|null interleaved array
     */
    private function generateDeep($depth)
    {
        if ($depth === 0) {
            return null;
        }

        $depthArray = array();

        for ($i = 0; $i < $depth - 1; $i++) {
            $array = $depthArray;
            $depthArray = array($array);
        }

        return $depthArray;
    }
    
    /**
     * Singleton classes are not allowed to be cloned
     *
     * @return void
     */
    private function __clone()
    {
        // Nothing to do here
    }
}