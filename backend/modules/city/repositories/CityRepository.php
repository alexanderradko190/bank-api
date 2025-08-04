<?php

namespace backend\modules\city\repositories;

use backend\modules\city\models\City;
use RuntimeException;

class CityRepository
{
    public function save(City $city): void
    {
        if (!$city->save(false)) {
            throw new RuntimeException('Ошибка сохранения города');
        }
    }

    public function delete(City $city): void
    {
        if (!$city->delete()) {
            throw new RuntimeException('Ошибка удаления города');
        }
    }

    public function findById(int $id): City
    {
        return City::findOne($id);
    }
}
