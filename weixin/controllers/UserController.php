<?php
namespace weixin\controllers;

//use yii\rest\ActiveController;
use yii\web\Controller;
use common\models\User;

class UserController extends Controller
{
    public function actionIndex(){
        return 'user\index';
    }
//    public $modelClass = 'common\models\User';
}