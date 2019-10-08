<?php 

namespace app\components;

use Yii;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Tags;

class Search extends Widget 
{
	public function run()
	{
		$tags = Tags::find()->all();

		$listTags = Array();

		foreach($tags as $tag)
		{
			$listTags[] = '"' . $tag->tag_name . '"';
		}

		$tags = implode(',', $listTags);

		return $this->render('search', [
			'tags' => $tags
		]);
	}
}