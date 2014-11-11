<?php

use yii\helpers\Html;
?>
<p>You have entred the following infomation:</p>
<ul>
    <li><label>Name: </label><?= Html::encode($model->name) ?></li>
    <li><label>Email: </label><?= Html::encode($model->email) ?></li>
</ul>