<?php
namespace App;

use App\twoDriver;
use App\gps;

class onAnHour extends templateTariff
{
    const PRICE_PER_TIME = 200;
    const PRICE_PER_DISTANCE = 0;
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
    //  Total result distance and time for students
    public function priceForStudents() {
        return $this->priceTime() * 1.1;
    }
    //  Total result distance and time
    public function distanceAndTime() {
        return $this->priceTime();
    }
    // Рассчет стоимости часа
    public function priceTime()
    {
        return ceil($this->times/60) * self::PRICE_PER_TIME ;
    }
}