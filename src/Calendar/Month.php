<?php 

namespace App\Calendar;

class Month{

    private $year;
    private $month;
    const MONTHS = ["01"=>"Janv","02"=>"Fév","03"=>"Mars","04"=>"Avril","05"=>"Mai","06"=>"Juin","07"=>"Juil","08"=>"Août","09"=>"Sept","10"=>"oct","11"=>"Nov","12"=>"Dec"];


    public function __construct($year,$month)
    {
        $this->year = $year;
        $this->month = strlen($month)==2 ? $month : "0".$month;
    }

    public function getLastDay(){
        $date = new \DateTime($this->year."-".$this->month."-01");
        return $date->format("t");
    }

    public function getNameMonth(){
        return self::MONTHS[$this->month];

    }
    public function getFirstDay(){
        $date = new \DateTime($this->year."-".$this->month."-01");
        return $date->format("N");

    }
    



}