<?php
namespace weixin\controllers;

use Yii;
use yii\web\Controller;
use weixin\models\Weixin;
use yii\web\Response;
/**
 * Site controller
 */
class SiteController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_XML;
        Yii::$app->response->formatters = [Response::FORMAT_XML=> 'weixin\component\MyXmlResponseFormatter'];

        $model = new Weixin;
        if(!$model->checkSignature())
            return ["error"=>"check signature error."];

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
