<?php
namespace weixin\controllers;

//use yii\rest\ActiveController;
use Yii;
use yii\web\Controller;
use common\models\User;

class UserController extends Controller
{
    public function actionIndex(){
        echo Yii::$app->request->get('echostr');
    }
//    public $modelClass = 'common\models\User';
}