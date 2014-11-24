<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/24
 * Time: 下午3:15
 */

namespace backend\models;

use yii\base\Model;

class QuickAddVideoForm extends Model{
    public $videoUrl;
    public $category;
    public $subCategory;

    public function rules(){
        return [
            [['videoUrl', 'category', 'subCategory'], 'required'],
        ];
    }

    public function vid(){
        return Youku::getVid($this->videoUrl);
    }
}