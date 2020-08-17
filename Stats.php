<?php

class Stats
{
    public $start_time;
    public $end_time;
    public $records;

    function __construct()
    {
        $this->start_time=gettimeofday();
        $this->end_time=null;
        $this->records=0;
    }

    function end()
    {
        $this->end_time=gettimeofday();
    }

    function inc()
    {
        ++$this->records;
    }

    function gettime()
    {
        $usec_diff=$this->end_time["usec"] - $this->start_time["usec"];
        $sec_diff=$this->end_time["sec"] - $this->start_time["sec"];
        if($usec_diff < 0)
        {
            $usec_diff+=1000000;
            --$sec_diff;
        }
        $result=$usec_diff / 1000000;
        $result+=$sec_diff;

        return $result;
    }

    function recspersec()
    {
        return $this->records / $this->gettime();
    }
}