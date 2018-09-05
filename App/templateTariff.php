<?php
namespace App;

interface Calc
{
    public function yearsCounter();
}

abstract class templateTariff implements Calc
{
    const PRICE_PER_TIME = 0;
    const PRICE_PER_DISTANCE = 0;
    public $times;
    public $distance;
    public $years;
    public $gps;
    public $thoDriver;
    public function countAge() {
        if (($this->years > 18) && ($this->years < 65)) {
            $this->yearsCounter();
        } elseif ($this->years < 18) {
            echo 'У вас еще нет прав';
            die;
        } elseif ($this->years > 65) {
            echo 'Вы уже слишком опытный';
            die;
        }
    }
    public abstract function yearsCounter();
    public function __construct($years, $times, $distance, $gps = false, $twoDriver = false)
    {
        $this->years = $years;
        $this->times = $times;
        $this->distance = $distance;
        $this->gps = $gps;
        $this->thoDriver = $twoDriver;
    }
}