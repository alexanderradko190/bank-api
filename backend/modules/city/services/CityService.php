<?php

namespace backend\modules\city\services;

use backend\modules\city\models\City;
use backend\modules\city\repositories\CityRepository;
use backend\modules\city\forms\CityForm;
use DomainException;
use Exception;

class CityService
{
    private $repository;

    public function __construct(CityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CityForm $form): City
    {
        $city = new City();
        $city->name = $form->name;
        $city->country_id = $form->country_id;
        $this->repository->save($city);

        return $city;
    }

    public function update($id, CityForm $form): City
    {
        $city = $this->repository->findById($id);

        if (!$city) {
            throw new DomainException('Город не найден');
        }

        $city->name = $form->name;
        $city->country_id = $form->country_id;
        $this->repository->save($city);

        return $city;
    }

    public function delete($id)
    {
        $city = $this->repository->findById($id);

        if (!$city) {
            throw new Exception('Город не найден');
        }

        $this->repository->delete($city);
    }
}
