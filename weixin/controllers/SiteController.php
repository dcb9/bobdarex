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

        if($postStr = $GLOBALS["HTTP_RAW_POST_DATA"]) {

            $postObject = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $model->setPostObject($postObject);

            switch($postObject->MsgType){
                case 'event':
                    return $model->getWelcomeContent();
                    break;
                case 'text':
                default:
                    return $model->getMusicContent();
                    break;
            }

        }else{
            return "";
        }
    }
}
