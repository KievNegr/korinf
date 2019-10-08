<?php 

use yii\helpers\Html;

?>

<div class="tags">
	<h6>Теги страницы: </h6>
	<?php
		foreach($tags as $tag)
		{
			echo Html::a($tag->tag_name, Yii::$app->urlManager->createUrl(['site/search', 'tag' => $tag->tag_name]), ['target' => '_blank']);
		}
	?>
</div>
<div style="clear: both;"></div>