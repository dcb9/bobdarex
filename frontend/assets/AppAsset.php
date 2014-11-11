<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/css/stylesheet.css',
        'static/css/retina.css',
    ];
    public $js = [
        'static/js/plugins/jquery-1.11.1.js',
        'static/js/plugins/jquery-ui.js',
        'static/js/plugins/banner.js',
        'static/js/plugins/jquery.scrollTo.min.js',
        'static/js/plugins/scrollpagination.js',
        'static/js/module/main.js',
        'static/js/module/ctrl.js'
    ];
    public $depends = [
    ];
}
