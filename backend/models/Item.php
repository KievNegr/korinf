<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Item extends ActiveRecord
{
 	/*public $sef;
 	public $title;
 	public $description;
 	public $keywords;
 	public $name;
 	public $code;
 	public $info;
 	public $fulltext;*/

 	public function afterFind()
 	{
 		//$img = $this->img;
 		//$this->img = 'http://korinf/web/images/upload/item/' . $img;
 	}

 	public function rules()
 	{
 		return [
 			[ ['sef', 'title', 'description', 'keywords', 'name', 'code', 'info', 'full_text'], 'required' ],
 			[ ['sef', 'title', 'description', 'keywords', 'name', 'code', 'info'], 'trim' ]
 		];
 	}
}
