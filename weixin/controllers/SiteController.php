<?php
namespace weixin\controllers;

use Yii;
use yii\web\Controller;
use weixin\models\Weixin;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $model = new Weixin;
        if(!$model->checkSignature())
            exit("check signature error.");

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        return $model->responseMsg($postStr);
    }
}
