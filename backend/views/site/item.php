<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use app\components\Tags;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\components\Category;
use yii\widgets\ActiveForm;

$this->title = $item->title;

echo Html::csrfMetaTags();

foreach($breadcrumbs as $bread)
{
    $this->params['breadcrumbs'][] = $bread;
}

echo \kato\DropZone::widget([
       'options' => [
       		'url' => Yii::$app->urlManager->createUrl('images'),
       		'parallelUploads' => 4,
           'maxFilesize' => '2',
       ],
       'clientEvents' => [
           'complete' => "function(file){console.log(file)}",
           'removedfile' => "function(file){alert(file.name + ' is removed')}"
       ],
   ]);
?>

<article>
	<?php echo Html::input('button', 'save', 'Сохранить', ['id' => 'save-item', 'class' => 'save-button']); ?>
	<p class="edit-p">Sef  (ЧПУ):</p>
	<?php echo Html::input('text', 'sef', $item->sef, ['class' => 'edit-input caution']); ?>
	<p class="edit-p">Title:</p>
	<?php echo Html::input('text', 'title', $item->title, ['class' => 'edit-input']); ?>
	<p class="edit-p">Description:</p>
	<?php echo Html::input('text', 'description', $item->description, ['class' => 'edit-input']); ?>
	<p class="edit-p">Keywords:</p>
	<?php echo Html::input('text', 'keywords', $item->keywords, ['class' => 'edit-input']); ?>
	<p class="edit-p">Название (он же H1):</p>
	<?php echo Html::input('text', 'name', $item->name, ['class' => 'edit-input']); ?>
	<p class="edit-p">Категория: <span class="open-sel-cat"><?php echo $itemNameCategory->name; ?></span></p>
	<?php echo Html::input('hidden', 'category', $item->category); ?>
	<div class="top-block">
		<div class="gallery">
			<div class="index-img">
				<div style="width: 30%;">
					<p class="edit-p">Изображение в списке:</p>
					<?php $imageIndex = ActiveForm::begin(['action' => 'http://adminkorinf/edititem/' . $item->id . '.html' , 'options' => ['enctype' => 'multipart/form-data']]); ?>
					<?php echo Html::img('http://korinf/web/images/upload/item/' . $item->img, ['class' => 'item-img']); ?>
					<?php //echo Html::input('file', 'imgInd', null, ['id' => 'userfile', 'class' => 'imgInd']); ?>
					<?php echo $imageIndex->field($f, 'imageind')->fileInput(['id' => 'userfile']); ?>
					<?php echo Html::submitButton('send'); ?>
					<?php ActiveForm::end(); ?>
					<div id="file_holder"></div>
				</div>
				<div style="width: 70%;">
					<p class="edit-p">Короткое описание в общем списке:</p>
					<?php echo Html::textarea('short_text', $item->short_text, ['class' => 'edit-textarea', 'style' => 'width: 90%; height: 100px;']); ?>
				</div>
			</div>
			<p class="edit-p">Изображения галереи:</p>
			<?php
				foreach($gallery as $image)
				{
					echo Html::beginTag('div', ['class' => 'list-img-gallery']);
					echo Html::a(Html::img($image->thumbs), $image->img, ['target' => '_blank']);
					echo Html::beginTag('div', ['style' => 'clear: both;']) . Html::endTag('div');
					echo Html::beginTag('div', ['class' => 'edit-list-img-gallery']) . Html::endTag('div');
					echo Html::beginTag('div', ['class' => 'delete-list-img-gallery']) . Html::endTag('div');
					echo Html::beginTag('div', ['style' => 'clear: both;']) . Html::endTag('div');
					echo Html::endTag('div');
				}
			?>
			<div style="clear: both;"></div>
		</div>
		<div class="info">
			<p class="edit-p">Код:</p>
			<?php echo Html::input('text', 'code', $item->code, ['class' => 'edit-input']); ?>
			<p class="edit-p">Краткая информация:</p>
			<?php echo Html::textarea('info', $item->info, ['class' => 'edit-textarea']); ?>
		</div>
	</div>
	
	<div class="tabs-block">
		<p class="edit-p">Полный текст:</p>
		<?php echo Html::textarea('full_text', $item->full_text, ['class' => 'edit-textarea area-100']); ?>
	</div>

	<?php
		if(!empty($tags)) echo Tags::widget(['tags' => $tags]);
	?>
</article>
<div class="selectCategory">
<div class="selCatClose">×</div>
<h4>Выбрать категорию</h4>
<?php echo Category::widget(['category' => $categories, 'selId' => $item->category]); ?>
</div>

<?php
$script = <<<JS
	var csrfToken = $('meta[name="csrf-token"]').attr("content");

	$('html').on('click', '#save-item', function()
	{
		$.ajax({
			url: 'http://adminkorinf/edititem/$item->id.html',
			data: {
				sef: $('input[name=sef]').val(),
				title: $('input[name=title]').val(),
				description: $('input[name=description]').val(),
				keywords: $('input[name=keywords]').val(),
				name: $('input[name=name]').val(),
				category: $('input[name=category]').val(),
				code: $('input[name=code]').val(),
				info: $('textarea[name=info]').val(),
				short_text: $('textarea[name=short_text]').val(),
				fulltext: $('textarea[name=full_text]').val(),
				_csrf: csrfToken
			},
			type: 'POST',
			success: function(res) 
			{
				alert(res);
			},
			error: function()
			{
				alert('error');
			}
		});
	});

	$('html').on('click', '.show', function()
	{
		$('.show').removeClass('bold');
		$(this).addClass('bold');
		$('.selectCategory').fadeOut();
		$('.open-sel-cat').text($(this).text());
		$('input[name=category]').val($(this).attr('id').substr(5));
	});

	$('html').on('click', '.open-sel-cat', function()
	{
		$('.selectCategory').fadeIn();
	});

	$('html').on('click', '.selCatClose', function()
	{
		$('.selectCategory').fadeOut();
	});
JS;

$this->registerJs($script);
?>