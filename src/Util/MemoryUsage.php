<?php

namespace Argon\PhpCommon\Util;

use Argon\PhpCommon\Util\Exception\UtilException;

/**
 * Class MemoryUsage
 *
 * Simple class for capturing and calculating memory usage of PHP
 *
 * @author  Dominic Roenicke <argonthechecker@gmail.com>
 * @package Argon\PhpCommon\Util
 */
class MemoryUsage
{
    /**
     * Divisor for Megabyte calculation
     *
     * @var integer
     */
    const FORMAT_DIVISOR_MB = 1000000;

    /**
     * Divisor for Kilobyte calculation
     *
     * @var integer
     */
    const FORMAT_DIVISOR_KB = 1000;

    /**
     * Divisor for Byte calculation
     *
     * @var integer
     */
    const FORMAT_DIVISOR_BYTE = 1;

    /**
     * Format key for Megabyte
     *
     * @var string
     */
    const FORMAT_KEY_MB = 'mb';

    /**
     * Format key for Kilobyte
     *
     * @var string
     */
    const FORMAT_KEY_KB = 'kb';

    /**
     * Format key for Byte
     *
     * @var string
     */
    const FORMAT_KEY_BYTE = 'byte';

    /**
     * @var MemoryUsage
     */
    private static $instance;

    /**
     * Map for formatKey calculations
     *
     * @var array
     */
    private $formatMap = array(
        self::FORMAT_KEY_KB => self::FORMAT_DIVISOR_KB,
        self::FORMAT_KEY_MB => self::FORMAT_DIVISOR_MB,
        self::FORMAT_KEY_BYTE => self::FORMAT_DIVISOR_BYTE
    );

    /**
     * @var boolean
     */
    private $realUsage = false;

    /**
     * @var array
     */
    private $memoryUsageCaptures = array();
    
    /**
     * Returns an instance of this class.
     * Saves the instance in static class variable.
     *
     * @return MemoryUsage
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }

    /**
     * Returns whether real memory usage will be used for capturing
     *
     * @see http://php.net/manual/de/function.memory-get-usage.php
     *
     * @return boolean
     */
    public function isRealUsage()
    {
        return $this->realUsage;
    }

    /**
     * Sets whether the real usage of memory will be used or not
     *
     * @see http://php.net/manual/de/function.memory-get-usage.php
     *
     * @param boolean $realUsage flag
     *
     * @return void
     */
    public function setRealUsage($realUsage)
    {
        $this->$realUsage = $realUsage;
    }

    /**
     * Resets all captured mamory usages
     *
     * @return void
     */
    public function reset()
    {
        $this->memoryUsageCaptures = array();
    }

    /**
     * Saves the current memory usage under the given capture key
     *
     * @param string $captureKey capture key for saving memory usage
     *
     * @return void
     */
    public function capture($captureKey)
    {
        $this->memoryUsageCaptures[$captureKey] = $this->getMemoryUsage();
    }

    /**
     * Returns the difference between two memory usages.
     * Calculation is: end - start
     *
     * @param string $startCaptureKey start capture key
     * @param string $endCaptureKey end capture key
     * @param string $formatKey (optional) output format (e.g. mb), case insensitive
     *
     * @return float|integer
     *
     * @throws UtilException when given format key is unknown
     */
    public function diff($startCaptureKey, $endCaptureKey, $formatKey = self::FORMAT_KEY_KB)
    {
        $startMemoryUsage = $this->getCapturedMemoryUsage($startCaptureKey, self::FORMAT_KEY_BYTE);
        $endMemoryUsage = $this->getCapturedMemoryUsage($endCaptureKey, self::FORMAT_KEY_BYTE);

        return $this->format($endMemoryUsage - $startMemoryUsage, $formatKey);
    }

    /**
     * Returns the memory usage of a given capture point
     *
     * @param string $captureKey key of the capture point
     * @param string $formatKey (optional) output format (e.g. mb), case insensitive
     *
     * @return float|integer
     *
     * @throws UtilException when given format key is unknown
     */
    public function getCapturedMemoryUsage($captureKey, $formatKey = self::FORMAT_KEY_KB)
    {
        if (!array_key_exists($captureKey, $this->memoryUsageCaptures)) {
            return null;
        }

        return $this->format($this->memoryUsageCaptures[$captureKey], $formatKey);
    }

    /**
     * Returns the current memory allocated by PHP in bytes
     *
     * @see http://php.net/manual/de/function.memory-get-usage.php
     *
     * @return integer
     */
    public function getMemoryUsage()
    {
        return memory_get_usage($this->isRealUsage());
    }

    /**
     * Returns the peak of memory allocated by PHP in bytes
     *
     * @see http://php.net/manual/de/function.memory-get-peak-usage.php
     *
     * @return integer
     */
    public function getMemoryPeakUsage()
    {
        return memory_get_peak_usage($this->isRealUsage());
    }

    /**
     * Conversion from byte in given format (e.g. megabyte).
     * If given convert format is byte, the memory usage will be returned without conversion.
     *
     * @param integer $memoryUsage memory usage in byte
     * @param string $formatKey (optional) output format (e.g. mb), case insensitive
     *
     * @return float|int calculated value
     * @throws UtilException when given format key is unknown
     */
    public function format($memoryUsage, $formatKey)
    {
        $formatKey = strtolower($formatKey);

        if ($formatKey === self::FORMAT_KEY_BYTE) {
            return $memoryUsage;
        }

        if (!array_key_exists($formatKey, $this->formatMap)) {
            throw new UtilException(
                'Unknown format key "' .
                $formatKey .
                '". Available formats: ' .
                implode(',', array_keys($this->formatMap))
            );
        }

        $divisor = $this->formatMap[$formatKey];

        return (float) $memoryUsage / $divisor;
    }

    /**
     * Singelton classes are not allowed to be instanciated directly
     */
    protected function __construct()
    {
        // Nothing to do here
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
