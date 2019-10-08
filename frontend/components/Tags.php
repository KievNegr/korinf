<?php 

namespace app\components;

use Yii;

use yii\base\Widget;

class Tags extends Widget 
{
	public $tags;

	public function run()
	{
		return $this->render('tags', [
			'tags' => $this->tags
		]);
	}
}