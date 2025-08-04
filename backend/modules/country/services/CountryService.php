<?php

namespace backend\modules\country\services;

use backend\modules\country\models\Country;
use backend\modules\country\repositories\CountryRepository;
use backend\modules\country\forms\CountryForm;
use DomainException;
use Exception;

class CountryService
{
    private CountryRepository $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CountryForm $form): Country
    {
        if ($this->repository->findByName($form->name)) {
            throw new DomainException('Страна с таким названием уже существует');
        }

        $country = new Country();
        $country->name = $form->name;
        $this->repository->save($country);

        return $country;
    }

    public function update($id, CountryForm $form): Country
    {
        $country = $this->repository->findById($id);

        if (!$country) {
            throw new Exception('Страна не найдена');
        }

        $exists = $this->repository->findByName($form->name);

        if ($exists) {
            throw new Exception('Страна с таким названием уже существует');
        }

        $country->name = $form->name;
        $this->repository->save($country);

        return $country;
    }

    public function delete($id): void
    {
        $country = $this->repository->findById($id);

        if (!$country) {
            throw new Exception('Страна не найдена');
        }

        $this->repository->delete($country);
    }
}
