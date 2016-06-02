<?php

namespace Savjee\BpostTrack;

class StatusUpdate
{
    private $date;
    private $time;
    private $status;
    private $location;

    /**
     * StatusUpdate constructor.
     * @param $date
     * @param $time
     * @param $status
     * @param $location
     */
    public function __construct($date, $time, $status, $location)
    {
        $this->setDate($date);
        $this->setTime($time);
        $this->setStatus($status);
        $this->setLocation($location);
    }


    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }
}