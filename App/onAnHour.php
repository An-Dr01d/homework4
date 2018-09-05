<?php
namespace App;

use App\twoDriver;
use App\gps;

class onAnHour extends templateTariff
{
    const PRICE_PER_TIME = 200;
    const PRICE_PER_DISTANCE = 0;
    use gps, twoDriver;

    // Проверка на студента
    public function yearsCounter()
    {
        if($this->years > 21) {
            return $this->standardPrice();
        } else {
            return $this->studentPrice();
        }
    }
    //  Рассчет стоимости для с доп. услугами
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
    //  Рассчет стоимости для студентов с доп. усоугами
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
    //  Стоимость часа для студентов
    public function priceForStudents() {
        return $this->priceTime() * 1.1;
    }
    //  Рассчет стоимости часа
    public function distanceAndTime() {
        return $this->priceTime();
    }
    // Округление до часа
    public function priceTime()
    {
        return ceil($this->times/60) * self::PRICE_PER_TIME ;
    }
}