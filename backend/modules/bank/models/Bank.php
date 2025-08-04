<?php

namespace backend\modules\bank\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use backend\modules\country\models\Country;
use backend\modules\city\models\City;
use backend\modules\service\models\Service;

class Bank extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%bank}}';
    }

    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    public function getCities(): ActiveQuery
    {
        return $this->hasMany(City::class, ['id' => 'city_id'])
            ->viaTable('bank_city', ['bank_id' => 'id']);
    }

    public function getServices(): ActiveQuery
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->viaTable('bank_service', ['bank_id' => 'id']);
    }
}
