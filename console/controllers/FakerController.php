<?php

namespace console\controllers;

use yii\console\Controller;
use backend\modules\country\models\Country;
use backend\modules\city\models\City;
use backend\modules\service\models\Service;
use backend\modules\bank\models\Bank;
use Yii;

class FakerController extends Controller
{
    public function actionFill()
    {
        Yii::$app->db->createCommand()->delete('bank_service')->execute();
        Yii::$app->db->createCommand()->delete('bank_city')->execute();
        Yii::$app->db->createCommand()->delete('bank')->execute();
        Yii::$app->db->createCommand()->delete('city')->execute();
        Yii::$app->db->createCommand()->delete('service')->execute();
        Yii::$app->db->createCommand()->delete('country')->execute();

        $countryNames = [
            'Россия',
            'Казахстан',
            'США',
            'Германия',
            'Китай',
        ];

        $countryModels = [];

        foreach ($countryNames as $name) {
            $country = new Country(['name' => $name]);
            $country->save(false);
            $countryModels[] = $country;
        }

        $citiesByCountry = [
            'Россия' => ['Москва', 'Санкт-Петербург', 'Новосибирск'],
            'Казахстан' => ['Алматы', 'Нур-Султан', 'Шымкент'],
            'США' => ['New York', 'Los Angeles', 'Chicago'],
            'Германия' => ['Берлин', 'Мюнхен', 'Франкфурт'],
            'Китай' => ['Пекин', 'Шанхай', 'Шэньчжэнь'],
        ];

        $cityModels = [];

        foreach ($countryModels as $country) {
            foreach ($citiesByCountry[$country->name] as $cityName) {
                $city = new City([
                    'name' => $cityName,
                    'country_id' => $country->id,
                ]);
                $city->save(false);
                $cityModels[] = $city;
            }
        }

        $serviceNames = [
            'Вклады',
            'Кредиты',
            'Займы МКК',
            'Лизинг',
            'Ипотека',
            'Страхование',
            'Дебетовые карты',
            'Расчетно-кассовое обслуживание',
            'Интернет-банкинг',
        ];

        $serviceModels = [];

        foreach ($serviceNames as $srv) {
            $service = new Service(['name' => $srv]);
            $service->save(false);
            $serviceModels[] = $service;
        }

        $bankData = [
            ['name' => 'Сбербанк России', 'country' => 'Россия'],
            ['name' => 'Казком Казахстана', 'country' => 'Казахстан'],
            ['name' => 'Bank of America', 'country' => 'США'],
            ['name' => 'DeutscheBank Germany', 'country' => 'Германия'],
            ['name' => 'Bank of China', 'country' => 'Китай'],
        ];

        foreach ($bankData as $bankRow) {
            $country = Country::findOne(['name' => $bankRow['country']]);
            $cities = City::find()->where(['country_id' => $country->id])->all();
            $cityIds = array_map(fn($c) => $c->id, $cities);
            shuffle($cityIds);
            $cityIds = array_slice($cityIds, 0, rand(1, count($cityIds)));

            $serviceIds = array_map(fn($s) => $s->id, $serviceModels);
            shuffle($serviceIds);
            $serviceIds = array_slice($serviceIds, 0, rand(3, 6));

            $description = "Банк относится к стране {$bankRow['country']}";

            $bank = new Bank([
                'name' => $bankRow['name'],
                'description' => $description,
                'country_id' => $country->id,
            ]);
            $bank->save(false);

            foreach ($cityIds as $cityId) {
                Yii::$app->db->createCommand()
                    ->insert('bank_city', ['bank_id' => $bank->id, 'city_id' => $cityId])
                    ->execute();
            }

            foreach ($serviceIds as $serviceId) {
                Yii::$app->db->createCommand()
                    ->insert('bank_service', ['bank_id' => $bank->id, 'service_id' => $serviceId])
                    ->execute();
            }
        }

        echo "Данные успешно сгенерированы!\n";
    }
}
