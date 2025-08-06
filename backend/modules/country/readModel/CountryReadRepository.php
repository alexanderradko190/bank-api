<?php

namespace backend\modules\country\readModel;

use backend\core\repositories\ReadRepositoryInterface;
use backend\modules\country\models\Country;
use yii\data\ActiveDataProvider;

class CountryReadRepository implements ReadRepositoryInterface
{
    public function getList(array $filters = []): ActiveDataProvider
    {
        $query = Country::find();

        if (!empty($filters['name'])) {
            $query->andWhere(['like', 'name', $filters['name']]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => $filters['per-page'] ?? 10],
        ]);
    }
}