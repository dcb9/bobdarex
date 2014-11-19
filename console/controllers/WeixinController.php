<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/19
 * Time: 下午9:45
 */

namespace console\controllers;


use yii\console\Controller;
use weixin\models\Weixin;

class WeixinController extends Controller {
    public function actionCreateMenu(){
        $model = new Weixin;
        $result = $model->createMenu();
        var_dump($result);
    }

    public function actionHelp(){
        $actions = [
            "create-menu",
            "help",
        ];
        $result = "";
        foreach($actions as $row){
            $result .= sprintf("\t%s\n", $row);
        }
        printf("./yii weixin/<action>\nactions:\n%s"
            ,$result);
    }

} 