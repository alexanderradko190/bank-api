<?php

namespace backend\modules\bank\repositories;

use backend\modules\bank\models\Bank;
use Exception;
use Yii;
use yii\db\ActiveQuery;

class BankRepository
{
    public function save(Bank $bank): void
    {
        if (!$bank->save(false)) {
            throw new Exception('Ошибка сохранения банка');
        }
    }

    public function updateCities($bankId, $cityIds): void
    {
        Yii::$app->db->createCommand()->delete('bank_city', ['bank_id' => $bankId])->execute();

        foreach ($cityIds as $cityId) {
            Yii::$app->db->createCommand()
                ->insert('bank_city', ['bank_id' => $bankId, 'city_id' => $cityId])
                ->execute();
        }
    }

    public function updateServices($bankId, $serviceIds): void
    {
        Yii::$app->db->createCommand()->delete('bank_service', ['bank_id' => $bankId])->execute();

        foreach ($serviceIds as $serviceId) {
            Yii::$app->db->createCommand()
                ->insert('bank_service', ['bank_id' => $bankId, 'service_id' => $serviceId])
                ->execute();
        }
    }

    public function findAllNotDeleted(): ActiveQuery
    {
        return Bank::find()->where(['is_deleted' => 0]);
    }

    public function findByNotDeleted(int $id): ?Bank
    {
        return Bank::find()->where(['id' => $id, 'is_deleted' => 0])->one();
    }

    public function findByNotDeletedById(int $id): ?Bank
    {
        return Bank::findOne(['id' => $id, 'is_deleted' => 0]);
    }

    public function findByName(string $name): ?Bank
    {
        return Bank::find()->where(['name' => $name])->one();
    }
}
