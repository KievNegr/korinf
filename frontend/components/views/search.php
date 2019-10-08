<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
	echo Html::radio('search-check', false, ['id' => 'show-search']);
	echo Html::label('', 'show-search', ['class' => 'search']);
	echo Html::radio('search-check', false, ['id' => 'close-search']);
	echo Html::label('×', 'close-search', ['class' => 'search-close']);
?>

<div class="site-search-block">
	<?php

		$form = ActiveForm::begin(['method' => 'post', 'action' => ['search/'],]);

		echo '<input type="text" placeholder="Поиск оборудования" autocomplete="off" name="tag" data-provide="typeahead" data-items="20" data-source=\'[' . $tags . ']\'>';

		echo Html::submitButton('Найти', ['id' => 'btn-search']);

		ActiveForm::end();
	?>
	<div style="clear: both;"></div>
</div>