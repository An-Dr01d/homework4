<?php
namespace App;

use App\twoDriver;
use App\gps;

class forStudents extends templateTariff
{
    const PRICE_PER_TIME = 1;
    const PRICE_PER_DISTANCE = 4;
    use gps, twoDriver;
    // Проверка на студента
    public function yearsCounter()
    {
        if(($this->years > 21) && ($this->years < 25)) {
            return $this->standardPrice();
        } elseif ($this->years < 21) {
            return $this->studentPrice();
        } else {
            return "Тариф доступен только для студентов";
        }
    }
    //  Проверка активации доп. услуг
    public function standardPrice()
    {
        if ($this->gps === false) {
            return $this->distanceAndTime();
        } elseif ($this->gps === true) {
            return $this->distanceAndTime() + $this->times * $this->gpsCost();
        }
    }
    //  Проверка активации доп. услуг для студентов
    public function studentPrice()
    {
        if ($this->gps === false) {
            return $this->priceForStudents();
        } elseif ($this->gps === true) {
            return $this->priceForStudents() + $this->times * $this->gpsCost();
        }
    }
    //  Рассчет стоимости для студентов
    public function priceForStudents() {
        return ($this->priceDistance() + $this->priceTime()) * 1.1;
    }
    //  Рассчет общей стоимости
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
        return $this->times * self::PRICE_PER_TIME;
    }
}