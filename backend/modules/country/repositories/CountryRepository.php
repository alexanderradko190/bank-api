<?php

namespace backend\modules\country\repositories;

use backend\modules\country\models\Country;
use RuntimeException;

class CountryRepository
{
    public function save(Country $country)
    {
        if (!$country->save(false)) throw new RuntimeException('Ошибка сохранения страны');
    }

    public function delete(Country $country)
    {
        if (!$country->delete()) throw new RuntimeException('Ошибка удаления страны');
    }

    public function findById(int $id): Country
    {
        return Country::findOne($id);
    }

    public function findByName(string $name): ?Country
    {
        return Country::find()->where(['name' => $name])->one();
    }
}
