<?php

namespace backend\modules\country\dto;

class CountryDto
{
    public $id;
    public $name;

    public function __construct($country)
    {
        $this->id = $country->id;
        $this->name = $country->name;
    }

    public static function many($arr)
    {
        return array_map(fn($c) => new self($c), $arr);
    }
}
