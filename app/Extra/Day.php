<?php
namespace App\Extra;
class Day{
    public bool $isopen;
    public string $start;
    public string $end;


    public function __construct(bool $isopen=false, string $start=null,string $end=null)
    {
        $this->isopen =$isopen ;
        $this->start = $start??"10:00 AM";
        $this->end = $end??"05:00 PM";
    }
};
