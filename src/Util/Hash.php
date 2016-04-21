<?php

namespace Argon\PhpCommon\Util;

use Argon\PhpCommon\Util\Exception\UtilException;

/**
 * Class Hash
 *
 * Singleton Class
 * For generating Hashes from any type of Variable.
 *
 * @author Dominic Roenicke <argonthechecker@gmail.com>
 * @package Argon\PhpCommon\Util
 */
class Hash
{
    /**
     * @var Hash
     */
    private static $instance;

    /**
     * Returns a singleton object of this class
     *
     * @return Hash
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Creates a hash value from an object.
     * Php internal function spl_object_hash() is used to get a unique object identifier.
     *
     * @param object $object object to create a hash value from
     * @param string $hashAlgo (optional) hash algorithm to be used
     *
     * @return string hash
     * @throws UtilException when given object is no object
     */
    public function generateFromObject($object, $hashAlgo = 'sha1')
    {
        if (!is_object($object)) {
            throw new UtilException('Given object is not an object: "' . gettype($object) .  '" given');
        }

        return hash($hashAlgo, spl_object_hash($object));
    }

    /**
     * Creates a hash value from an array.
     *
     * @param array $array array to create a hash value from
     * @param string $hashAlgo (optional) hash algorithm to be used
     *
     * @return string hash
     */
    public function generateFromArray(array $array, $hashAlgo = 'sha1')
    {
        return hash($hashAlgo, json_encode($array));
    }

    /**
     * Generates a hash from any value type
     *
     * @param mixed $value value to generate a hash from
     * @param string $hashAlgo (optional) hash algorithm to be used
     *
     * @return string hash
     */
    public function generate($value, $hashAlgo = 'sha1')
    {
        $hash = null;

        if (is_object($value)) {
            try {
                $hash = $this->generateFromObject($value, $hashAlgo);
            } catch (UtilException $ex) {
                // should never be thrown here
            }
        } elseif (is_array($value)) {
            $hash = $this->generateFromArray($value, $hashAlgo);
        } else {
            $hash = hash($hashAlgo, $value);
        }

        return $hash;
    }

    /**
     * Singletons are not allowed to be cloned
     *
     * @return void
     */
    private function __clone()
    {
        //Nothing to do here
    }

    /**
     * Singelton classes are not allowed to be instanciated directly
     */
    protected function __construct()
    {
        //Nothing to do here
    }
}