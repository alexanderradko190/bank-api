<?php

namespace backend\modules\city\forms;

use yii\base\Model;

class CityForm extends Model
{
    public $name;
    public $country_id;

    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['country_id'], 'integer'],
        ];
    }
}
