<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/14
 * Time: 上午10:01
 */

namespace weixin\models;

use Yii;
use yii\base\Model;

class Weixin extends Model{
    const TOKEN = "bobdarex";
    const ENCODING_AES_KEY = "T9FwIpxZpTg3M058qeBXZVXJgIJbn7JUj0HaU9ntVlP";

    public function responseMsg($postStr=""){

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>';
            if(!empty( $keyword )) {
                // 如果用户有输入内容，则我们就回复。
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                return sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            }else{
                return "Input something...";
            }

        }
        return "";
    }

    /**
     * 检查signature的准确性
     *
     * @return boolean
     */
    public function checkSignature(){
        $signature = Yii::$app->request->get('signature');
        $timestamp = Yii::$app->request->get('timestamp');
        $nonce =Yii::$app->request->get('nonce');

        $generatorSignature = $this->_generatorSignature($timestamp, $nonce, self::TOKEN);
        return $generatorSignature == $signature;
    }

    /**
     * 生成Signature的方法，这个应该和微信那里的算法是一致的，这样才能得到相同的结果。
     *
     * @param int $timestamp 微信那边传过来的时间戳
     * @param string $nonce
     * @param string $token 微信后台设置的token值 $token 微信后台设置的token值
     * @return string
     */
    private function _generatorSignature($timestamp, $nonce, $token = self::TOKEN){
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr =sha1($tmpStr);
        return $tmpStr;
    }
}