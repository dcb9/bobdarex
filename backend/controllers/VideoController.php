<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/24
 * Time: 下午3:21
 */

namespace backend\controllers;

use yii\web\Controller;
use backend\models\QuickAddVideoForm;
use backend\models\Youku;

class VideoController extends Controller {

    public function actionIndex(){
        $postData = ['QuickAddVideoForm'=>[
            'videoUrl'=>'http://v.youku.com/v_show/id_XODMxNTMyNjI4.html',
            'category'=>'街头',
            'subCategory'=>'滑板'
        ]];

        $model = new QuickAddVideoForm();
        if($model->load($postData) && $model->validate()){
            return $this->render("index.twig", [
                'youku'=>[
                    'clientId'=>Youku::$clientId,
                    'vid'=>$model->vid(),
                ]
            ]);
        } else {
            return $this->render("index.twig", ["message"=>"error"]);
        }
    }
}