<?php
namespace App;

use App\twoDriver;
use App\gps;

class base extends templateTariff
{
    const PRICE_PER_TIME = 3;
    const PRICE_PER_DISTANCE = 10;
    use gps;
    use twoDriver;

    // Рассчет стоимости часа
    public function priceTime()
    {
        return $this->times * self::PRICE_PER_TIME;
    }

    // Рассчет стоимости км
    public function priceDistance()
    {
        return $this->distance * self::PRICE_PER_DISTANCE;
    }

    //  Рассчет общей стоимости
    public function distanceAndTime() {
        return $this->priceDistance() + $this->priceTime();
    }

    // Проверка на студента
    public function yearsCounter()
    {
        if($this->years > 21) {
            return $this->standardPrice();
        } else {
            return $this->studentPrice();
        }
    }
    //  Проверка активирована ли услуга GPS
    public function standardPrice()
    {
        if ($this->gps === false) {
            return $this->distanceAndTime();
        } elseif ($this->gps === true) {
            return $this->distanceAndTime() + $this->times * $this->gpsCost();
        }
    }
    //  Рассчет стоимости для студентов с доп. услугой GPS
    public function studentPrice()
    {
        if ($this->gps === false) {
            return $this->priceForStudents();
        } elseif ($this->gps === true) {
            return $this->priceForStudents() + $this->times * $this->gpsCost();
        }
    }
    //  Рассчет стоимость для студентов
    public function priceForStudents() {
        return ($this->priceDistance() + $this->priceTime()) * 1.1;
    }

}
