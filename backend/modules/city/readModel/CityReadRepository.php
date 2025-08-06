<?php

namespace backend\modules\city\readModel;
use backend\core\repositories\ReadRepositoryInterface;
use backend\modules\city\models\City;
use yii\data\ActiveDataProvider;

class CityReadRepository implements ReadRepositoryInterface
{
    public function getList(array $filters = []): ActiveDataProvider
    {
        $query = City::find();

        if (!empty($filters['country_id'])) {
            $query->andWhere(['country_id' => $filters['country_id']]);
        }

        if (!empty($filters['name'])) {
            $query->andWhere(['like', 'name', $filters['name']]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $filters['per-page'] ?? 10],
        ]);
    }
}