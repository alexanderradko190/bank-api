<?php

namespace backend\modules\bank\dto;

class BankDto
{
    public $id;
    public $name;
    public $description;
    public $country;
    public $cities = [];
    public $services = [];

    public function __construct($bank)
    {
        $this->id = $bank->id;
        $this->name = $bank->name;
        $this->description = $bank->description;
        $this->country = $bank->country ? ['id' => $bank->country->id, 'name' => $bank->country->name] : null;
        $this->cities = array_map(fn($city) => ['id' => $city->id, 'name' => $city->name], $bank->cities);
        $this->services = array_map(fn($srv) => ['id' => $srv->id, 'name' => $srv->name], $bank->services);
    }

    public static function many($arr)
    {
        return array_map(fn($b) => new self($b), $arr);
    }
}
