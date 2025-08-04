<?php

namespace backend\modules\service\forms;

use yii\base\Model;

class ServiceForm extends Model
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
