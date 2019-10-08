<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Коринф инжиниринг - европейское оборудование для пищевой промышленности';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Продажа, установка и обслуживание европейского пищевого оборудования в Украине, Россие, Казахстане'
    ]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Коринф, инжиниринг, пищевое оборудование, revent, kornfeil, polin, oem, agnelli, sarp, padovani, selmi, canol'
    ]);
?>
<!--SLIDER-->
<div class="slider">
    <div class="slide-1 slide" style="background-image: url('images/slider/1.jpg');">
    </div>

    <div class="slide-2 slide" style="background-image: url('images/slider/2.jpg');">
    </div>

    <div class="slide-3 slide" style="background-image: url('images/slider/3.jpg');">
    </div>

    <div class="slide-4 slide" style="background-image: url('images/slider/4.jpg');">
    </div>

    <div class="slide-fade"></div>
</div><!--/slider-->

<div class="block-slider">
    <h1 class="up h1-slide">Коринф инжиниринг</h1>
    <h3 class="up h3-slide">Европейское оборудование для пищевой промышленности и гастробизнеса</h3>
    <div class="search-block">  
        <?php 
            $form = ActiveForm::begin(['method' => 'post', 'action' => ['search/'],]);
            echo '<input type="text" placeholder="Начните поиск оборудования" autocomplete="off" name="tag" data-provide="typeahead" data-items="20" data-source=\'[' . $tags . ']\'>';

            echo Html::submitButton('Найти', ['id' => 'btn-search']);

            ActiveForm::end();
        ?>
        <div style="clear: both;"></div>
    </div>
</div>
<div class="air"></div>

<!--/SLIDER-->

<!--<div class="back-temp" style="background-image: url('../images/upload/iffip2018.jpg');"></div>
<div class="back-temp-descr">
    <h2 class="h1 up">IFFIP 2018</h2>
    <h3 class="h2 up">18 - 20 АПРЕЛЯ 2018</h2>
    <p style="color: #FFF;">Международный форум пищевой промышленности и упаковки</p>
    <p style="color: #FFF;">Международный Выставочный Центр (МВЦ)<br />г.Киев, Броварской пр-т, 15, метро Левобережная</p>
    <a href="http://korinf-group.com/page/expo-iffip-2018.html" style="font-family: 'Exo 2'; font-size: 1.25em; background-color: #095da7; color: #FFF; padding: 4px 10px 7px 10px;" target="_blank">Читать далее</a>
</div>-->

<div class="index-menu">
    <h2 class="center up index-h2">Уникальная функциональность</h2>
    <h4 class="center w-center w-70 index-h4">энергосберегающие технологии, любые комплектации, индивидуальный расчет бюджета</h4>
    <?php
        $l = 0;
        foreach($categories as $category)
        {
            /*if($l == 0){
                echo Html::beginTag('div', ['class' => 'block-80']);
                    echo Html::beginTag('div', ['class' => 'block-80-text']);
                        echo Html::beginTag('h2', ['style' => 'letter-spacing: -2.4px;']);
                        echo $category->short_text;
                        echo Html::endTag('h2');
                        echo Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]), ['class' => 'link-text-index']);
                    echo Html::endTag('div');
                    echo Html::beginTag('div', ['class' => 'block-80-img', 'style' => 'background-image: url(' . $category->img . ');']);
                    echo Html::endTag('div');
                echo Html::endTag('div');
                $l = 1;
            }else{
                echo Html::beginTag('div', ['class' => 'block-80']);
                    echo Html::beginTag('div', ['class' => 'block-80-img', 'style' => 'background-image: url(' . $category->img . ');']);
                    echo Html::endTag('div');
                    echo Html::beginTag('div', ['class' => 'block-80-text']);
                        echo Html::beginTag('h2', ['style' => 'letter-spacing: -2.4px;']);
                        echo $category->short_text;
                        echo Html::endTag('h2');
                        echo Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]), ['class' => 'link-text-index']);
                    echo Html::endTag('div');
                echo Html::endTag('div');
                $l = 0;
            }*/

            echo Html::beginTag('div', ['class' => 'block-24 center']);
            echo Html::a(Html::img($category->img, ['alt' => $category->name, 'title' => $category->name]), Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]));
            echo Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]), ['class' => 'link-text']);
            echo Html::endTag('div');
        }
    ?>
</div>

<div class="preimushestva">
    <h2 class="center up" style="width: 100%;">Сотрудничество с компанией Коринф это:</h2>   
    <div class="block-33">
        <img src="images/cooperation/project.jpg" />
        <h5>Проекты «под ключ»</h5>
    </div>
    <div class="block-33">
        <img src="images/cooperation/quality.jpg" />
        <h5>Гарантии качества</h5>
    </div>
    <div class="block-33">
        <img src="images/cooperation/delivery.jpg" />
        <h5>Удобные сроки поставки</h5>
    </div>
    <div class="block-33">
        <img src="images/cooperation/stock.jpg" />
        <h5>Наличие на складе</h5>
    </div>
    <div class="block-33">
        <img src="images/cooperation/equipment.jpg" />
        <h5>Комплектации</h5>
    </div>
    <div class="block-33">
        <img src="images/cooperation/task.jpg" />
        <h5>Сервис</h5>
    </div>
</div><!--/preimushestva-->

<div class="logo-partners">
    <h2 class="center up">Мы предлагаем оборудование ведущих мировых производителей</h2>
    <div class="slider-partners">
        <div class="block-20">
            <img src="images/partners/revent.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/polin.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/padovani.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/oem.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/sarp.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/kornfeil.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/canol.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/agnelli.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/agriflex.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/retigo.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/campagnolo.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/gsp.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/sp.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/ram.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/macpan.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/restoline.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/mixer.png" />
        </div>
        <div class="block-20">
            <img src="images/partners/tecnomac.png" />
        </div>
    </div>
</div><!--/logo-partners-->

<div class="clients-block">
    <h2 class="center up">Наши клиенты знают,</h2>
    <h4 class="center w-center w-90" style="letter-spacing: -1px;">что сотрудничество с компанией «Коринф» – это залог комплектации своего производства оборудованием отменного качества, оперативное решение вопросов с дополнительной комплектацией и обслуживанием высокого уровня.</h4>

    <div class="clients">
        <div class="block-20">
            <img src="images/clients/3bears.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/novus.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/varus.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/silpo.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/herkules.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/farro.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/elika.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/carhleb.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/batosha.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/kishenya.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/kievhleb.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/kiev_pirogki.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/eko.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/shantil.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/verona.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/mamamia.png" />
        </div>
        <div class="block-20">
            <img src="images/clients/spar.png" />
        </div>
    </div><!--/clients-->
</div>
<!--
<div class="feedback">
    <div class="back-feedback">
        <h2 style="color: #FFF;" class="m-20 up">Наши специалисты</h2>
        <h4 style="color: #FFF;" class="m-20">являются экспертами в области оборудования для пищевой промышленности, поэтому вы всегда можете проконсультироваться с ними по интересующим вас вопросам.</h4>
        <h4 style="color: #FFF;" class="m-20">Напишите нам через форму обратной связи или <a href="contacts.html">позвоните нам</a> .</h4>
    </div>
    <div class="feedback-form">
        <input type="text" name="name" id="name-user" class="input" placeholder="Ваше имя" /><br />
        <input type="text" name="phone" id="phone-user" class="input" placeholder="Телефон для связи" />
        <textarea id="question-user" class="input" placeholder="Ваш вопрос"></textarea>
        <input type="button" name="submit" id="sbm-feedback" value="Отправить" />
    </div>
</div>-->
