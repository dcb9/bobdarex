<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/14
 * Time: 上午10:01
 */

namespace weixin\models;

use Yii;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\base\Model;
use common\component\MyXmlResponseFormatter as MXRF;

class Weixin extends Model{
    const TOKEN = "bobdarex";
    // 下面两个值是我自己测试帐号的值

    const APPID = "wx60ab301bf65da4b1";
    const SECRET ="9a76656ec6bc6c61f8a1e5efdc54528c";

    const EVENT_KEY_V1001_TODAY_MUSIC = "V1001_TODAY_MUSIC";

    public static $_eventKeyInfo =[
        self::EVENT_KEY_V1001_TODAY_MUSIC=>[
        "type"=> "click",
        "name"=>"今日金歌",
        "key"=> self::EVENT_KEY_V1001_TODAY_MUSIC,
        ]
    ];

    protected  $postObject = null;


    public function setPostObject($object){
        if(is_object($object)){
            $this->postObject = $object;
        }else{
            throw new InvalidParamException();
        }
    }

    public function getClickEventResponseContent(){
        $eventKey = $this->postObject->EventKey;
        switch($eventKey){
            case self::EVENT_KEY_V1001_TODAY_MUSIC:
                $info = "生如夏花 朴树";
                return $this->getMusicContent($info);
                break;
            default:
                break;
        }
    }

    /**
     *
     * 目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。
     * 一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。
     * 请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。
     * 建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
     * @return array|bool
     * @throws ErrorException
     */
    public function createMenu(){
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=". self::getAccessToken();
        $data = [
            "button" => [
                self::$_eventKeyInfo[self::EVENT_KEY_V1001_TODAY_MUSIC]
                , [
                    "name"=>"菜单",
                    "sub_button"=>[
                        [
                            "type"=>"view",
                            "name"=>"搜索",
                            "url"=>"http://www.soso.com/",
                        ],[
                            "type"=>"view",
                            "name"=>"视频",
                            "url"=>"http://www.youku.com/",
                        ],[
                            "type"=>"click",
                            "name"=>"点赞",
                            "key"=>"V1001_GOOD",
                        ],
                    ],
                ],[
                    "type"=>"pic_sysphoto",
                    "name"=>"拍张靓照",
                    "key"=>"rselfmenu_1_0",
                ],
            ],
        ];

        return self::postDataToUrl($url, $data);
    }

    /**
     * 获取返回数据，响应点歌
     * @param type $postObj 微信推送过来的数据对象
     * @return text 格式化的字符串
     */
    public function getMusicContent($recognition=null) {
        $postObj = $this->postObject;

        if($recognition===null)
            $recognition = (string)$postObj->Content;

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
            $encode = (string)$itemobj->encode;
            $decode = (string)$itemobj->decode;
            $removedecode = end(explode('&', $decode));
            if ($removedecode <> "") {
                $removedecode = "&" . $removedecode;
            }
            $decode = str_replace($removedecode, "", $decode);
            $musicurl = str_replace(end(explode('/', $encode)), $decode, $encode);
            break;
        }

        return [
            "ToUserName"=>[$postObj->FromUserName,MXRF::CDATA=>true],
            "FromUserName"=>[$postObj->ToUserName,MXRF::CDATA=>true],
            "CreateTime"=>time(),
            "MsgType"=>"music",
            "Music"=>[
                "Title"=>[$recognition,MXRF::CDATA=>true],
                "Description"=>[$decode,MXRF::CDATA=>true],
                "MusicUrl"=>[$musicurl,MXRF::CDATA=>true],
                "HQMusicUrl"=>[$musicurl,MXRF::CDATA=>true],
            ]
        ];
    }
    /**
     *  获取返回数据，响应文字流
     * @param resource $postObj 微信推送过来的数据对象
     * @return text 格式化的字符串
     */
    public function getTextContent() {
        $postObj = $this->postObject;
        $MsgType = 'text'; //回复类型
        $GetMsg = $postObj->Content; //用户发送的内容
        //如果输入的是以下文字，后期会进行其他处理，目前还没做。
        $MsgArray = array('文章', '技术', '其他', '笑话');
        if (in_array($GetMsg, $MsgArray)) {
            $RetMsg = '您需要的' . $GetMsg . '还没有找到，好吧，就算找到了也不会回给你。';
        } else {
            $RetMsg = '亲，如果您是点歌，那么很遗憾没有找到您点的歌，请确认后再次点歌。如果您是来逗我的话，对不起，我宁死不从。我也是有贞操的。';
        }

        return [
            "ToUserName"=>[$postObj->FromUserName, MXRF::CDATA=>true],
            "FromUserName"=>[$postObj->ToUserName, MXRF::CDATA=>true],
            "CreateTime"=>time(),
            "MsgType"=>[$MsgType, MXRF::CDATA=>true],
            "Content"=>[$RetMsg, MXRF::CDATA=>true],
        ];
    }

    public function getWelcomeContent(){
        if($this->postObject->Event=="subscribe") {

            $Content = '欢迎关注PHP技术文章,本公众号会不定时分享PHP相关技术性文章。当然，无聊也开发了一些小功能，目前可用的是点歌功能，输入歌名或歌名[空格]歌星，即可点歌。个人网站：www.yelongyi.com';
            return [
                "ToUserName"=>[$this->postObj->FromUserName, MXRF::CDATA=>true],
                "FromUserName"=>[$this->postObj->ToUserName, MXRF::CDATA=>true],
                "CreateTime"=>time(),
                "MsgType"=>'text',
                "Content"=>[$Content, MXRF::CDATA=>true],
            ];
        }else{
            //这里是取消关注，暂时不做处理
            return [];
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

    /**
     * @param array $options
     * @return array|bool
     */
    public static function curlExec(array $options){
        $defaultOptions = array(
            CURLOPT_RETURNTRANSFER=>1,
        );
        $options = $options + $defaultOptions;

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $returnContent  =  curl_exec($ch);
        if($returnContent === false){
            return false;
        }else{
            $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            return array($returnCode, $returnContent);
        }
    }

    /**
     * 把json数据通过post形式发送给一个url
     *
     * @refer http://blog.csdn.net/zhulei632/article/details/8014921
     * @param string $url
     * @param array $data
     * @return array|bool
     */
    public function postDataToUrl($url, array $data){
        /*
         *  JSON_UNESCAPED_UNICODE 参数是必写的，因为不然的话中文会被转成 \uxxx 格式的字符
         * ，但是微信的全局返回代码的 4003明确规定不能包含这个字符了
         * 这个常量也只在 php5.4 以上才有，加上这个中文就不会被  unicode 和 escape 操作了。
         */
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $options = [
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>$json_data,
            CURLOPT_URL=>$url,
            CURLOPT_HTTPHEADER=>[
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: '.strlen($json_data),
            ]
        ];
        return self::curlExec($options);
    }

    public function getAccessToken(){

        $key = "weixin-access-token-v20141119";
        $accessToken = Yii::$app->cache->get($key);
        // 缓存里没有取到数据，再通过接口获取，然后放到缓存里面去。
        if($accessToken === false){
            $url = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s"
                , self::APPID, self::SECRET);
            $options = [
                CURLOPT_URL=>$url,
            ];
            $result = self::curlExec($options);
            if($result[0]==200){
                $accessToken = json_decode($result[1])->access_token;
                // 官方一个 token 的有效期为 7200 S 所以就缓存 7000 S
                Yii::$app->cache->set($key, $accessToken, 7000);
            }else{
                throw new ErrorException("Get Access Token Error. Code: {$result[0]}, Content: {$result[1]}");
            }
        }
        return $accessToken;
    }
}