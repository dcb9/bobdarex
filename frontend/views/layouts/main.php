<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerLinkTag([
    'rel'=>'Shortcut Icon',
    'href'=>'/static/images/idarex.ico'
]);

$this->registerMetaTag(['charset'=>'utf-8']);
$this->registerMetaTag(['http-equiv'=>'X-UA-Compatible', 'content'=>'IE=edge,chrome=1']);
$this->registerMetaTag(['name'=>'description', 'content'=>'iDarex敢玩网，汇集最精彩极限户外运动视频、报道最新极限运动资讯、汇聚最专业的极限户外玩家，加入iDareX，体验极限户外运动。']);
$this->registerMetaTag(['name'=>'keywords', 'content'=>'极限运动,户外运动,极限运动视频,户外装备,极限玩家,iDarex,敢玩']);
?>
<?php  $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript"> var cxt = ''; </script>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <header>
        <div>
            <nav>
                <ul>
                    <li><a href="javascript:;" class="logo"></a></li>
                    <li class="nav channel"><a href="javascript:;">频道</a>
                        <ul>
                            <li><a href="javascript:;" class="nav_street">街头 <em></em></a></li>
                            <li><a href="javascript:;" class="nav_mountain">山地 <em></em></a></li>
                            <li><a href="javascript:;" class="nav_water">水上 <em></em></a></li>
                            <li><a href="javascript:;" class="nav_sky">空中 <em></em></a></li>
                        </ul>
                    </li>
                    <li class="nav"><a href="http://bbs.idarex.com/portal.php" target="_blank">资讯</a></li>
                    <li class="nav"><a href="http://bbs.idarex.com/forum.php?mod=forumdisplay&amp;fid=2" target="_blank">交流</a></li>
                    <li class="nav"><a href="/aboutus.html">关于我们</a></li>
                </ul>
            </nav>
            <?php if(Yii::$app->user): ?>
                <div class="myspace login">
                    <a href="javascript:;"><span>Xer</span></a>
                    <span class="name"><?= HTML::encode(Yii::$app->user->identity->username) ?></span>
                    <input type="text" value="<?= HTML::encode(Yii::$app->user->identity->username) ?>" />
                    <em class="clickme"></em>
                </div>
                </div>
            <?php else: ?>
                <div class="myspace">
                    <a href="javascript:;">Be a &nbsp;<span>Xer</span></a>
                    <em class="clickme"></em>
                </div>
            <?php endif; ?>
        </div>
    </header>
    <!-- end header -->

    <!-- $content start -->
    <?= $content ?>
    <!-- end $content -->

    <footer class="footer">
        <div>京ICP备 14046167号-1</div>
        <div><?= 'Powered by &copy; ', date('Y'), ' idareX' ?></div>
    </footer>
    <input type="hidden" value="" id="sessionUser" />

    <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fc8c7c5286b23f16e1017166a2d3c47ec' type='text/javascript'%3E%3C/script%3E"));

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-54479926-1', 'auto');
        ga('send', 'pageview');
    </script>

    <div id="loginBox" class="popbox dn">
        <dl>
            <dt>
            <ul>
                <li class="borderR current">登录</li>
                <li>注册</li>
            </ul>
            <a href="javascript:;">X</a>
            </dt>
            <dd>
                <form id="loginForm" action="javascript:;">
                    <span class="error dn"></span>
                    <label>
                        邮箱：
                        <input type="text" id="lEmail" />
                    </label>
                    <label>
                        密码：
                        <input type="password" id="lPassword" />
                    </label>
                    <input type="submit" id="loginBoxLogin" value="登录" />
                    <a href="javascript:;" class="forgetpsw">忘记密码</a>
                </form>
                <form id="registerForm" class="dn" action="javascript:;">
                    <span class="error dn"></span>
                    <label>
                        邮箱：
                        <input type="text" id="rEmail" />
                    </label>
                    <label>
                        密码：
                        <input type="password" id="rPassword" />
                    </label>
                    <label class="confirmpsw">
                        确认密码：
                        <input type="password" id="rcPassword"  />
                    </label>
                    <input type="submit" id="loginBoxRegist" value="注册" />
                </form>
            </dd>
        </dl>
    </div>
    <!-- end #loginBox -->

    <div id="forgetPswBox" class="popbox dn">
        <dl>
            <dt>
                找回密码
                <a href="javascript:;">X</a>
            </dt>
            <dd>
                <span class="error dn"></span>
                <form action="javascript:;">
                    <label>
                        帐号邮箱：
                        <input type="text" />
                    </label>
                    <input type="submit" value="发送" />
                </form>
            </dd>
        </dl>
    </div>
    <!-- end #forgetPswBox -->

    <input type="hidden" value="" id="activeCode" />
    <div id="resetPswBox" class="popbox dn">
        <dl>
            <dt>
                重置密码
                <a href="javascript:;">X</a>
            </dt>
            <dd>
                <span class="error dn"></span>
                <form action="javascript:;">
                    <label class="psw1">
                        新密码：
                        <input type="password" />
                    </label>
                    <label class="psw2">
                        再次输入：
                        <input type="password" />
                    </label>
                    <input type="submit" value="确认" />
                </form>
            </dd>
        </dl>
    </div>
    <!-- end #forgetPswBox -->
    <?php
    $this->registerJsFile('static/js/module/index.js');
    ?>
    <script type="text/javascript">
        $(function(){
            var data = {banner: []};
            data.banner.push({"img":"uploads/article/2014/09/27/d5debd7abb094d9996b83da79741bef1.jpg", "url":"http://bbs.idarex.com/forum.php?mod=viewthread&tid=9&from=portal","alt":""});
            data.banner.push({"img":"uploads/article/2014/09/27/41aa99af49bc4ba08d3332ca4d5b1c1e.jpg", "url":"http://bbs.idarex.com/forum.php?mod=viewthread&tid=5&from=portal","alt":""});
            data.banner.push({"img":"uploads/article/2014/09/27/979d6e8e660a4277a0f842612a44e4f3.jpg", "url":"http://bbs.idarex.com/forum.php?mod=viewthread&tid=6&from=portal","alt":""});
            data.banner.push({"img":"uploads/article/2014/09/27/0da8465aeeb84d70b253c348597e0364.jpg", "url":"http://bbs.idarex.com/forum.php?mod=viewthread&tid=8&from=portal","alt":""});
            data.banner.push({"img":"uploads/article/2014/09/27/056dbf786571412c9d29e0f1477407b2.jpg", "url":"http://bbs.idarex.com/forum.php?mod=viewthread&tid=7&from=portal","alt":""});
            //调用方法
            spinner({data: data, node: $("#banner_slide")});

        })
    </script>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>