<?php

namespace backend\modules\service\readModel;

use backend\core\repositories\ReadRepositoryInterface;
use backend\modules\service\models\Service;
use yii\data\ActiveDataProvider;

class ServiceReadRepository implements ReadRepositoryInterface
{
    public function getList(array $filters = []): ActiveDataProvider
    {
        $query = Service::find();

        if (!empty($filters['name'])) {
            $query->andWhere(['like', 'name', $filters['name']]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $filters['per-page'] ?? 10],
        ]);
    }
}