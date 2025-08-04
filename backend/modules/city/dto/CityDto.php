<?php

namespace backend\modules\city\dto;

class CityDto
{
    public $id;
    public $name;
    public $country_id;

    public function __construct($city)
    {
        $this->id = $city->id;
        $this->name = $city->name;
        $this->country_id = $city->country_id;
    }

    public static function many($arr)
    {
        return array_map(fn($c) => new self($c), $arr);
    }
}
