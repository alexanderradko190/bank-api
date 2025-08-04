<?php

namespace backend\modules\country\forms;

use yii\base\Model;

class CountryForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
        ];
    }
}
