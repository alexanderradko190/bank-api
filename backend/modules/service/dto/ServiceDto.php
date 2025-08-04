<?php

namespace backend\modules\service\dto;

class ServiceDto
{
    public $id;
    public $name;

    public function __construct($service)
    {
        $this->id = $service->id;
        $this->name = $service->name;
    }

    public static function many($arr)
    {
        return array_map(fn($c) => new self($c), $arr);
    }
}
