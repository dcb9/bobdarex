<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/14
 * Time: 上午10:01
 */

namespace weixin\models;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;

class Weixin extends Model{
    const TOKEN = "bobdarex";
    protected  $postObject = null;


    public function setPostObject($object){
        if(is_object($object)){
            $this->postObject = $object;
        }else{
            throw new InvalidParamException();
        }
    }

    /**
     * 获取返回数据，响应点歌
     * @param type $postObj 微信推送过来的数据对象
     * @return text 格式化的字符串
     */
    public function getMusicContent() {
        $postObj = $this->postObject;
        $ret = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Music>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[]]></Description>
            <MusicUrl><![CDATA[%s]]></MusicUrl>
            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
            <FuncFlag><![CDATA[1]]></FuncFlag>
            </Music>
            </xml>";
        $recognition = $postObj->Content;
        //判断格式是否为歌名+明星
        if (strstr($recognition, " ")) {
            $strArray = explode(" ", $recognition);
            $keywordc = urlencode($strArray[0]);
            $keyword2 = urlencode($strArray[1]);
        } else {
            $keywordc = urlencode($recognition);
            $keyword2 = null;
        }
        //这里歌曲库拿的是百度音乐，歌曲还是比较全的
        $musicapi = "http://box.baidu.com/x?op=12&count=1&title={$keywordc}\$\${$keyword2}\$\$\$\$";
        $simstr = file_get_contents($musicapi);
        $musicobj = simplexml_load_string($simstr);
        //如果没有搜寻到歌曲，按输入文字处理
        if (empty($musicobj->count)) {
            return $this->getTextContent($postObj);
        }
        foreach ($musicobj->url as $itemobj) {
            $encode = $itemobj->encode;
            $decode = $itemobj->decode;
            $removedecode = end(explode('&', $decode));
            if ($removedecode <> "") {
                $removedecode = "&" . $removedecode;
            }
            $decode = str_replace($removedecode, "", $decode);
            $musicurl = str_replace(end(explode('/', $encode)), $decode, $encode);
            break;
        }
        $resultStr = sprintf($ret, $postObj->FromUserName, $postObj->ToUserName, time(), 'music', $recognition, $decode, $musicurl, $musicurl);
        return $resultStr;
    }


    /**
     *  获取返回数据，响应文字流
     * @param resource $postObj 微信推送过来的数据对象
     * @return text 格式化的字符串
     */
    public function getTextContent() {
        $postObj = $this->postObject;
        $ret = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $MsgType = 'text'; //回复类型
        $GetMsg = $postObj->Content; //用户发送的内容
        //如果输入的是以下文字，后期会进行其他处理，目前还没做。
        $MsgArray = array('文章', '技术', '其他', '笑话');
        if (in_array($GetMsg, $MsgArray)) {
            $RetMsg = '您需要的' . $GetMsg . '还没有找到，好吧，就算找到了也不会回给你。';
        } else {
            $RetMsg = '亲，如果您是点歌，那么很遗憾没有找到您点的歌，请确认后再次点歌。如果您是来逗我的话，对不起，我宁死不从。我也是有贞操的。';
        }
        $resultStr = sprintf($ret, $postObj->FromUserName, $postObj->ToUserName, time(), $MsgType, $RetMsg);
        return $resultStr;
    }

    public function getWelcomeContent(){
        if($this->postObject->Event=="subscribe") {
            $textTpl = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%d</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>';

            $MsgType = 'text';
            $Content = '欢迎关注PHP技术文章,本公众号会不定时分享PHP相关技术性文章。当然，无聊也开发了一些小功能，目前可用的是点歌功能，输入歌名或歌名[空格]歌星，即可点歌。个人网站：www.yelongyi.com';
            return sprintf($textTpl, $this->postObj->FromUserName, $this->postObj->ToUserName, time(), $MsgType, $Content);
        }else{
            //这里是取消关注，暂时不做处理
            return "";
        }
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