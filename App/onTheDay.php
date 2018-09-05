<?php

namespace App;

use App\twoDriver;
use App\gps;

class onTheDay extends templateTariff
{
    const PRICE_PER_TIME = 1000;
    const PRICE_PER_DISTANCE = 1;
    use gps, twoDriver;
    // Result with check on students
    public function yearsCounter()
    {
        if($this->years > 21) {
            return $this->standardPrice();
        } else {
            return $this->studentPrice();
        }
    }
    //  Check for activation of additional services for all users
    public function standardPrice()
    {
        if (!$this->gps && !$this->thoDriver) {
            return $this->distanceAndTime();
        } elseif (($this->gps === true) && ($this->thoDriver === false)) {
            return $this->distanceAndTime() + $this->times * $this->gpsCost();
        } elseif (($this->gps === false) && ($this->thoDriver === true)) {
            return $this->distanceAndTime() + $this->twoDriver();
        } elseif (($this->gps === true) && ($this->thoDriver === true)) {
            return $this->distanceAndTime() + $this->twoDriver() + ($this->times * $this->gpsCost());
        }
    }
    //  Check for activation of additional services for students
    public function studentPrice()
    {
        if (!$this->gps && !$this->thoDriver) {
            return $this->priceForStudents();
        } elseif (($this->gps === true) && ($this->thoDriver === false)) {
            return $this->priceForStudents() + $this->times * $this->gpsCost();
        } elseif (($this->gps === false) && ($this->thoDriver === true)) {
            return $this->priceForStudents() + $this->twoDriver();
        } elseif (($this->gps === true) && ($this->thoDriver === true)) {
            return $this->priceForStudents() + $this->twoDriver() + ($this->times * $this->gpsCost());
        }
    }
    //  Рассчет стоимость для студентов
    public function priceForStudents() {
        return ($this->priceDistance() + $this->priceTime()) * 1.1;
    }
    // Рассчет общей стоимости
    public function distanceAndTime() {
        return $this->priceDistance() + $this->priceTime();
    }
    // Рассчет стоимости км
    public function priceDistance()
    {
        return $this->distance * self::PRICE_PER_DISTANCE;
    }
    // Рассчет стоимости часа
    public function priceTime()
    {
        return floor($this->times/24) * self::PRICE_PER_TIME;
    }
}