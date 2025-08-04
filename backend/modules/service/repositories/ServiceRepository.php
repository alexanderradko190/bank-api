<?php

namespace backend\modules\service\repositories;

use backend\modules\service\models\Service;
use RuntimeException;

class ServiceRepository
{
    public function save(Service $service): void
    {
        if (!$service->save(false)) {
            throw new RuntimeException('Ошибка сохранения услуги');
        }
    }

    public function delete(Service $service): void
    {
        if (!$service->delete()) {
            throw new RuntimeException('Ошибка удаления услуги');
        }
    }

    public function findByName(string $name): ?Service
    {
        return Service::find()->where(['name' => $name])->one();
    }

    public function findById(int $id): ?Service
    {
        return Service::findOne($id);
    }
}
