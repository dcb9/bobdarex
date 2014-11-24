<?php
/**
 * Created by PhpStorm.
 * User: bob
 * Date: 14/11/24
 * Time: 下午5:14
 */

namespace backend\models;
use yii\base\Model;

class Youku extends Model{
    public static $clientId = "dd59bd271d8a8175";


    /**
     * http://v.youku.com/v_show/id_XODA4NjkxNDY4.html
     *
     * @param $url
     */
    public static function getVid($url){

        $pattern ='/id_(.*?).html/';
        preg_match($pattern, $url, $matches);

        return $matches[1];
    }

} 