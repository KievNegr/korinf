<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;

AppAsset::register($this);

$active = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div id="header">
    <div class="logo"></div><!--/logo-->
    <nav>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['index']);?>" <?php if($active == 'index') {?>class="active"<?php } ?>>Настройки</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['tags']);?>" <?php if($active == 'tags') {?>class="active"<?php } ?>>Управление тегами</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['equipment']);?>" <?php if($active == 'equipment') {?>class="active"<?php } ?>>Оборудование</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['pages']);?>" <?php if($active == 'pages') {?>class="active"<?php } ?>>Страницы</a>
    </nav><!--/menu-->
    <div class="exit">
        <a href="<?php echo Yii::$app->urlManager->createUrl(['logout']);?>">Выход</a>
    </div>
    <div class="admin">
        Админская
    </div>
</div><!--/header-->
<?php
    echo Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
?>
<div id="wrapper">

<?php echo $content; ?>

</div><!--/wrapper-->

<div id="footer">
    <div class="block">
        <div class="footer-logo"></div>
        <p>Административная страница</p>  
        <p><?php echo 'Version of PHP ' . phpversion();?></p>             
    </div>

    <div class="footer-menu">
        <a href="<?php echo Yii::$app->urlManager->createUrl(['index']);?>">Главная</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['settings']);?>">Настройки</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['tags']);?>">Управление тегами</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['equipment']);?>">Оборудование</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['pages']);?>">Страницы</a>
    </div>

</div><!--/footer-->

<div id="top">↑</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
