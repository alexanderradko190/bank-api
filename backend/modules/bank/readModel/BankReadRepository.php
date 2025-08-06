<?php

namespace backend\modules\bank\readModel;

use backend\core\repositories\ReadRepositoryInterface;
use backend\modules\bank\models\Bank;
use yii\data\ActiveDataProvider;

class BankReadRepository implements ReadRepositoryInterface
{
    public function getList(array $filters = []): ActiveDataProvider
    {
        $query = Bank::find()->alias('b')->where(['b.is_deleted' => 0]);

        if (!empty($filters['country'])) {
            $query->joinWith('country c')->andWhere(['c.name' => $filters['country']]);
        }

        if (!empty($filters['city'])) {
            $query->joinWith('cities ct')->andWhere(['ct.name' => $filters['city']]);
        }

        if (!empty($filters['service'])) {
            $query->joinWith('services s')->andWhere(['s.name' => $filters['service']]);
        }

        if (!empty($filters['name'])) {
            $query->andWhere(['like', 'b.name', $filters['name']]);
        }

        return new ActiveDataProvider([
            'query' => $query->distinct(),
            'pagination' => [
                'pageSize' => $filters['per-page'] ?? 10,
            ],
        ]);
    }
}