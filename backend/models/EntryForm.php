<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/10
 * Time: обнГ9:48
 */

namespace backend\models;

use yii\base\Model;

class EntryForm extends Model {
    public $name;
    public $email;

    public function rules(){
        return [
            [['name', 'email'], 'required']
            , ['email', 'email']
        ];
    }
} 