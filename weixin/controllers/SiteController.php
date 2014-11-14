<?php
namespace weixin\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        // url: weixin.bobdarex.phpor.me/site 或 weixin.bobdarex.phpor.me
        return Yii::$app->request->get('echostr');
    }
    public function actionBob(){
        // url: weixin.bobdarex.phpor.me/site/bob
        return 'site/bob';
    }
    public function actionBobTest(){
        // url: weixin.bobdarex.phpor.me/site/bob-test
        return 'site/bob-test。。。。。';
    }
}
