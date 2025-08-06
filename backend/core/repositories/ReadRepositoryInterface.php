<?php

namespace backend\core\repositories;

use yii\data\ActiveDataProvider;

interface ReadRepositoryInterface
{
    public function getList(array $filters = []): ActiveDataProvider;
}
