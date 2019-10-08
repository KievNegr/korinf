<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use app\components\Search;

AppAsset::register($this);

$active = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"  prefix="og: http://ogp.me/ns#">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-105182281-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-105182281-1');
</script>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<meta name="google-site-verification" content="gW5sX6Q1-3-V90yO5GTBk4GamX_gzpEfa5TZ-VIDc2g" />
	<meta property="og:url" content="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>" />
	<?php
		if(isset($this->context->image))
		{
			echo '<meta property="og:image" content="' . $this->context->image . '" />';
		}
		else
		{
			echo '<meta property="og:image" content="https://korinf-group.com/images/logo.png" />';
		}
	?>
	
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <?php
        if($this->context->noindex == true)
            echo '<meta name="robots" content="noindex, nofollow" />';

        if(isset($this->context->itemName))
        {
        	if($this->context->itemPrice != 0)
						{
							echo '<script type="application/ld+json">
				                  {
				                    "@context": "http://schema.org/",
				                    "@type": "Product",
				                    "name": "' . $this->context->itemName . '
				                  ",
				                    "image": [
				                      "https://' . $_SERVER[SERVER_NAME] . $_SERVER[REQUEST_URI] . '"
				                     ],
				                     "brand": "' . $this->context->itemBrand . '",
				                    "offers": {
				                      "@type": "Offer",
				                      "priceCurrency": "UAH",
				                      "price": "' . $this->context->itemPrice . '",
				                      "itemCondition": "http://schema.org/UsedCondition",
				                      "availability": "http://schema.org/InStock"
				                    }
				                  }
				                  </script>';
						}
        }
    ?>
</head>
<body>

<?php $this->beginBody() ?>

<div id="header">
    <a href="https://korinf-group.com/" title="Коринф Инжиниринг" alt="Коринф Инжиниринг" class="a-logo"><div class="logo"></div></a><!--/logo-->
    <nav>
        <!--<a href="http://korinf-group.com" <?php if($active == 'index') {?>class="active"<?php } ?>>Главная</a>-->
        <div class="drop-list">
            <a href="<?php echo Yii::$app->urlManager->createUrl(['equipment']);?>" <?php if($active == 'equipment') {?>class="active"<?php } ?>>Оборудование</a>
            <div class="drop-list-equipments transition">
                <?php
                    //if($_SERVER['REMOTE_ADDR'] == '31.128.72.110')
                    //{
                        foreach($this->context->menu as $menu)
                        {
                            echo Html::beginTag('div', ['class' => 'block-10 center']);
                            echo Html::a(Html::img($menu->img, ['alt' => $menu->name, 'title' => $menu->name]), Yii::$app->urlManager->createUrl(['equipment/' . $menu->sef]));
                            echo Html::a($menu->name, Yii::$app->urlManager->createUrl(['equipment/' . $menu->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;']);
                            echo Html::endTag('div');
                        }
                    //}
                ?>
            </div>
        </div>
        <!--<a href="<?php echo Yii::$app->urlManager->createUrl(['events']);?>" <?php if($active == 'events' || $active == 'page') {?>class="active"<?php } ?>>События</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['vacancies']);?>" <?php if($active == 'vacancies') {?>class="active"<?php } ?>>Вакансии</a>-->
        <a href="<?php echo Yii::$app->urlManager->createUrl(['contacts']);?>" <?php if($active == 'contacts') {?>class="active"<?php } ?>>Контакты</a>
        <?php echo Search::widget(); ?>
    </nav><!--/menu-->
    <div class="right-header">
        <div class="phone">+38(044)502-44-16</div>
        <div class="phone" style="margin-top: 5px;">+38(067)11-39-733</div>
    </div>
</div><!--/header-->
<div class="height-60"></div>
<?php
    echo Breadcrumbs::widget([
        'homeLink' => ['label' => 'Главная', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
?>
<div id="wrapper">

<?php echo $content; ?>

</div><!--/wrapper-->

<div id="footer">
    <div class="block">
        <div class="footer-logo"></div>
        <p>Европейское оборудование</p>
        <p>для пищевой промышленности.</p>
        <p>&copy; ООО «Коринф Инжиниринг» <?php echo date('Y');?></p>
        <div class="footer-soc">
            <a href="https://www.youtube.com/channel/UCVBChsLfWpRATvABeukbitA" target="_blank" class="youtube-min"></a>
            <a href="https://www.facebook.com/groups/korinf/" class="facebook-min"></a>
        </div>
        <div class="exchange-rate">
            <p>Курс валют на: <?php echo $this->params['date']; ?></p>
            <table>
                <tbody>
                    <tr>
                        <th></th>
                        <th>Продажа</th>
                    </tr>
                    <tr>
                        <td>EUR</td>
                        <td><?php echo $this->params['eur']; ?></td>
                    </tr>
                    <tr>
                        <td>USD</td>
                        <td><?php echo $this->params['usd']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>       
    </div>

    <div class="block">
        <h4>Контакты</h4>
        <p>04080 Украина, г.Киев, ул.Викентия Хвойки, 21, БЦ "Веста", проходная №4 а/я 212</p>
        <p>Тел.: +38(044)502-44-16</p>
        <p>Тел.: +38(067)11-39-733</p>
        <p>E-mail: <a href="mailto:svetlana@korinf.com.ua">svetlana@korinf.com.ua</a></p>
        <hr />
        <p>Украина, г.Днепр, ул. Героев Сталинграда, 16/64</p>
        <p>Тел.: +38(067) 611-22-11</p>
        <p>+38(056) 377-44-84</p>
        <p>Факс: +38(067) 231-56-28</p>
        <hr />
        <p>Czech Republic, Praha</p>
        <p>Nerudova 209/10, Malá Strana, 118 00 Praha 1</p>
        <p>Тел.: +38(067)235-17-00</p>
    </div>

    <div class="block">
        <h4>Карта проезда</h4>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2538.571041443867!2d30.485504315427992!3d50.48632897948031!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDI5JzEwLjgiTiAzMMKwMjknMTUuNyJF!5e0!3m2!1sru!2sua!4v1490015052872" width="250" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>

    <div class="footer-menu">
        <a href="https://korinf-group.com/">Главная</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['equipment']);?>">Оборудование</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['events']);?>">События</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['vacancies']);?>">Вакансии</a>
        <a href="<?php echo Yii::$app->urlManager->createUrl(['contacts']);?>">Контакты</a>
    </div>

</div><!--/footer-->
<style>
    .teler-wd__promo {position: absolute; left: 1000%;}
    .teler-wd__close {overflow: hidden; background: rgba(30, 32, 33, 0.63)!important;}
    .teler-wd__svg {width: 15px;height: 15px;}
</style>
<div class="tl-call-catcher"> <!--BANNER ON SITE--> </div>
<div id="top">➜</div>
<link href="https://fonts.googleapis.com/css?family=Exo+2:400,600,700" rel="stylesheet">
<link href="/css/slider.css" rel="stylesheet">
<link href="/css/banner.css" rel="stylesheet">
<link href="/css/typeahead.css" rel="stylesheet">
<link href="/css/mediaqueries.css" rel="stylesheet">
<?php $this->endBody() ?>
<script src="/js/korinf.js"></script>
<script src="/js/typeahead.min.js"></script>
<script src="/js/jquery.maskedinput.min.js"></script>
<script>var telerWdWidgetId="b7873839-5caf-4864-be15-d184ffeb3602";var telerWdDomain="korinf.phonet.com.ua";</script>
<script src="//korinf.phonet.com.ua/public/widget/call-catcher/lib-v3.js"></script>

</body>
</html>
<?php $this->endPage() ?>
