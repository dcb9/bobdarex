<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/17
 * Time: 下午5:45
 */

namespace console\controllers;

use yii\console\Controller;
use common\models\User;

class UserController extends Controller{
    public $color = true;
    public function actionUsers(){
        $users = User::findAll(['status' =>User::STATUS_ACTIVE]);
        foreach($users as $user){
            printf("userid: %d, username: %s, email: %s\r\n", $user->id, $user->username, $user->email);
        }
    }
}