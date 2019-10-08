<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\components\Tags;
use app\components\Category;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = $title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $description
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $keywords
]);

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}
?>

<div class="height-50"></div>

<h1><?php echo $h1; ?></h1>

<div class="filter">
    <input type="checkbox" id="open-filter" />
    <label for="open-filter" class="filter-open"></label>
    <?php echo Category::widget(['category' => $categories]); ?>
    <div class="content">
        <div class="content-list" style="margin: 0; padding: 0;">
            <?php 
                if($sef == 'index')
                {
                    foreach($categories as $category)
                    {
                        echo Html::beginTag('div', ['class' => 'block-24 center']);
                        echo Html::a(Html::img($category->img, ['alt' => $category->name, 'title' => $category->name]), Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]));
                        echo Html::a($category->name, Yii::$app->urlManager->createUrl(['equipment/' . $category->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;']);
                        echo Html::endTag('div');
                    }
                }
                else
                {
                    if($selectCategory->text_up == 1)
                    {
                        echo Html::decode($text);
                        echo Html::beginTag('div', ['style' => 'clear: both; width: 100%;']) . Html::endTag('div');
                    }
                    if($selectCategory->hide_list == 0)
                    {
                        foreach($items as $item)
                        {
                            echo Html::beginTag('div', ['class' => 'block-25 center divhover']);
                            echo Html::a(Html::img($item->img, ['alt' => $item->name, 'title' => $item->name]), Yii::$app->urlManager->createUrl(['stat/' . $item->sef]));
                            echo Html::a($item->name, Yii::$app->urlManager->createUrl(['stat/' . $item->sef]), ['class' => 'link-text', 'style' => 'font-size: 1em;']);
                            if($item->price != 0)
                            {
                                switch($item->availability){
                                    case 0: 
                                            echo Html::beginTag('span', ['class' => 'price equipm isnt']);
                                            echo number_format($item->price * $this->params['eur'], 2, '.', ' ') . " грн";
                                                echo Html::beginTag('span', ['class' => 'price-small']);
                                                echo "<br />Нет в наличии";
                                                echo Html::endTag('span');
                                            echo Html::endTag('span');
                                            break;
                                    case 1: 
                                            echo Html::beginTag('span', ['class' => 'price equipm']);
                                            echo number_format($item->price * $this->params['eur'], 2, '.', ' ') . " грн";
                                                echo Html::beginTag('span', ['class' => 'price-small']);
                                                echo "<br />Есть в наличии";
                                                echo Html::endTag('span');
                                            echo Html::endTag('span');
                                            break;
                                    case 2: 
                                            echo Html::beginTag('span', ['class' => 'price equipm maybe']);
                                            echo number_format($item->price * $this->params['eur'], 2, '.', ' ') . " грн";
                                                echo Html::beginTag('span', ['class' => 'price-small']);
                                                echo "<br />Наличие уточняйте";
                                                echo Html::endTag('span');
                                            echo Html::endTag('span');
                                            break;

                                }
                            }
                            else
                            {
                                switch($item->availability){
                                    case 0: 
                                            echo Html::beginTag('span', ['class' => 'price equipm isnt']);
                                            echo 'Цену уточняйте';
                                                echo Html::beginTag('span', ['class' => 'price-small']);
                                                echo "<br />Нет в наличии";
                                                echo Html::endTag('span');
                                            echo Html::endTag('span');
                                            break;
                                    case 1: 
                                            echo Html::beginTag('span', ['class' => 'price equipm']);
                                            echo 'Цену уточняйте';
                                                echo Html::beginTag('span', ['class' => 'price-small']);
                                                echo "<br />Есть в наличии";
                                                echo Html::endTag('span');
                                            echo Html::endTag('span');
                                            break;
                                    case 2: 
                                            echo Html::beginTag('span', ['class' => 'price equipm maybe']);
                                            echo 'Цену уточняйте';
                                                echo Html::beginTag('span', ['class' => 'price-small']);
                                                echo "<br />Наличие уточняйте";
                                                echo Html::endTag('span');
                                            echo Html::endTag('span');
                                            break;

                                }
                            }
                            echo Html::beginTag('p', ['class' => 'filter-p']);
                            echo $item->short_text;
                            echo Html::endTag('p');
                            echo Html::endTag('div');
                        }
                    }
                    echo Html::beginTag('div', ['style' => 'clear: both; width: 100%;']) . Html::endTag('div');
                    if($selectCategory->text_up == 0)
                    {
                        echo Html::decode($text);
                    }
                }

                if(!empty($tags)) echo Tags::widget(['tags' => $tags]);
            ?>
        </div>
    </div>
</div>