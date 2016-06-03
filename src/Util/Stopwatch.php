<?php

namespace Argon\PhpCommon\Util;

/**
 * Class Stopwatch
 *
 * Offers functionality of a stopwatch =)
 *
 * @author Dominic Roenicke <argonthechecker@gmail.com>
 * @package Argon\PhpCommon\Util
 */
class Stopwatch
{
    /**
     * Holds the time of start in milliseconds
     *
     * @var double
     */
    private $startTime = 0.0;

    /**
     * Holds the time of stop in milliseconds
     *
     * @var double
     */
    private $stopTime = 0.0;

    /**
     * Holds a list of remembered stop times in micro seconds
     *
     * @var array
     */
    private $rememberedStopTimes = array();

    /**
     * Starts the stopwatch.
     * Saves the start time.
     *
     * @return Stopwatch
     */
    public function start()
    {
        $this->startTime = $this->getCurrentMicroTime();

        return $this;
    }

    /**
     * Stops the stopwatch.
     * Saves the stop time.
     *
     * @return Stopwatch
     */
    public function stop()
    {
        $this->stopTime = $this->getCurrentMicroTime();

        return $this;
    }

    /**
     * Resets all values
     *
     * @return Stopwatch
     */
    public function reset()
    {
        $this->startTime = 0.0;
        $this->stopTime = 0.0;
        $this->rememberedStopTimes = array();

        return $this;
    }

    /**
     * Remembers the time when this method is called.
     * Saves the remembered time in a list.
     *
     * @param string|int $key (optional) key for recognizing remembered time
     *
     * @return Stopwatch
     */
    public function remember($key = null)
    {
        if ($key === null) {
            $this->rememberedStopTimes[] = $this->getCurrentMicroTime();
        } else {
            $this->rememberedStopTimes[$key] = $this->getCurrentMicroTime();
        }

        return $this;
    }

    /**
     * Returns a list of all remembered times.
     * All times are in milliseconds since start time.
     * An empty array will be returned when there are no remembered times.
     *
     * @return array list of remembered time
     */
    public function getRemembered()
    {
        $rememberedStopTimesList = array();

        foreach ($this->rememberedStopTimes as $time) {
            $rememberedStopTimesList[] = $time - $this->startTime;
        }

        return $rememberedStopTimesList;
    }

    /**
     * Returns the passed time from start to stop in milliseconds
     *
     * @param bool $autoreset flag for automaticly resetting while getting the time
     *
     * @return double
     */
    public function getTime($autoreset = false)
    {
        $time = $this->stopTime - $this->startTime;

        if ($autoreset === true) {
            $this->reset();
        }

        return $time;
    }

    /**
     * Returns the start time in milliseconds
     *
     * @return double
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Returns the stop time in milliseconds
     *
     * @return int
     */
    public function getStopTime()
    {
        return $this->stopTime;
    }

    /**
     * Returns the actual time in milliseconds
     *
     * @return double
     */
    public function getCurrentMicroTime()
    {
        return microtime(true);
    }

    /**
     * Returns the stopped time as string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTime();
    }
}
