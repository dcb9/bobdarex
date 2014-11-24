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
            'videoUrl'=>'http://v.youku.com/v_show/id_XODMzNTI5Njg4.html?f=23105794&ev=2&from=y1.1-2.10001-0.1-1',
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