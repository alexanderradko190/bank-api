<?php

namespace backend\modules\bank\forms;

use yii\base\Model;

class BankForm extends Model
{
    public $name;
    public $description;
    public $country_id;
    public $city_ids = [];
    public $service_ids = [];

    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string'],
            [['country_id'], 'integer'],
            [['city_ids', 'service_ids'], 'each', 'rule' => ['integer']],
        ];
    }
}
