<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Images extends ActiveRecord
{
 	public $img;
 	public $thumbs;

 	public function afterFind()
 	{
 		$img = $this->name;
 		$thumbs = $this->name;

 		$this->img = '/frontend/web/images/upload/item/gallery/' . $img;
 		$this->thumbs = '/frontend/web/images/upload/item/gallery/thumbs/' . $thumbs;
 	}   
}
