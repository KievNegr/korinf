<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\components\Category;
use yii\widgets\Breadcrumbs;

$this->title = 'Управление каталогом оборудования';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Управление каталогом оборудования'
]);

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}
?>

<h1>Управление каталогом оборудования</h1>
<article>
    <div class="flex">
        <div class="block-50">
            <h4>Список оборудования</h4>
            <a href="<?php echo yii::$app->urlManager->createUrl(['additem']);?>" class="add-new">+</a>
            <?php
                foreach($items as $item)
                {
                    echo Html::beginTag('p', ['class' => 'list category-' . $item->category]);
                    echo Html::a(Html::img('/admin/images/admin/edit.png', ['width' => '15', 'height' => '15', 'alt' => 'Редактировать', 'title' => 'Редактировать']), yii::$app->urlManager->createUrl(['edititem/' . $item->id]), ['title' => 'Редактировать', 'class' => 'icon-links']);
                    echo Html::a(Html::img('/admin/images/admin/delete.png', ['width' => '15', 'height' => '15', 'alt' => 'Удалить', 'title' => 'Удалить']), yii::$app->urlManager->createUrl(['site/aaa']), ['title' => 'Удалить', 'class' => 'icon-links']);
                    echo Html::a($item->name, yii::$app->urlManager->createUrl(['edititem/' . $item->id]), ['title' => 'Редактировать', 'class' => 'list-item']);
                    echo Html::endTag('p');
                }
            ?>
        </div>
        <div class="block-50">
            <h4>Список категорий</h4>
            <a href="<?php echo yii::$app->urlManager->createUrl(['addcategory']);?>" class="add-new">+</a>
            <?php echo Category::widget(['category' => $categories]); ?>
        </div>
    </div>
</article>

<?php
$script = <<<JS
    $('html').on('click', '.list-cat', function()
    {
        $('.list-cat').css({'font-weight': '400', 'color': '#2e76c3'});
        $(this).css({'font-weight': '600', 'color': '#404850'});

        id = $(this).attr('id').substr(5);

        $('.list').hide();

        $('.category-' + id).show();
    });
JS;

$this->registerJS($script);
?>