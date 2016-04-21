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
     * @var float
     */
    private $startTime = 0.0;

    /**
     * Holds the time of stop in milliseconds
     *
     * @var float
     */
    private $stopTime = 0.0;

    /**
     * Holds a list of remembered stop times in milliseconds
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
        $this->startTime = $this->getMicroTime();

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
        $this->stopTime = $this->getMicroTime();

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
        $this->pauseTime = 0.0;
        $this->rememberedStopTimes = array();

        return $this;
    }

    /**
     * Remembers the time when this method is called.
     * Saves the remembered time in a list.
     *
     * @return Stopwatch
     */
    public function remember()
    {
        $this->rememberedStopTimes[] = $this->getMicroTime();

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
     * @return integer
     */
    public function getTime()
    {
        return $this->stopTime - $this->startTime;
    }

    /**
     * Returns the start time in milliseconds
     *
     * @return integer
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Returns the stop time in milliseconds
     *
     * @return integer
     */
    public function getStopTime()
    {
        return $this->stopTime;
    }

    /**
     * Returns the actual time in milliseconds
     *
     * @return float
     */
    public function getMicroTime()
    {
        return microtime(true);
    }
}
