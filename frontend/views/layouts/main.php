<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerLinkTag([
    'rel'=>'Shortcut Icon',
    'href'=>'/frontend/web/static/images/idarex.ico'
]);

$this->registerMetaTag(['charset'=>'utf-8']);
$this->registerMetaTag(['http-equiv'=>'X-UA-Compatible', 'content'=>'IE=edge,chrome=1']);
$this->registerMetaTag(['name'=>'description', 'content'=>'iDarex敢玩网，汇集最精彩极限户外运动视频、报道最新极限运动资讯、汇聚最专业的极限户外玩家，加入iDareX，体验极限户外运动。']);
$this->registerMetaTag(['name'=>'keywords', 'content'=>'极限运动,户外运动,极限运动视频,户外装备,极限玩家,iDarex,敢玩']);
$this->title = 'iDareX敢玩 - 极限户外运动平台';
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
            <div class="myspace">
                <a href="javascript:;">Be a &nbsp;<span>Xer</span></a>
                <em class="clickme"></em>
            </div>
        </div>
    </header>
    <!-- end header -->

    <div class="wrap">
        <?php
        /*
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        */
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div>京ICP备 14046167号-1</div>
        <div><?= 'Powered by &copy; ', date('Y'), ' idareX' ?></div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>