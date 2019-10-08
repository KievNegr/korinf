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
 	//public $img;

 	public function afterFind()
 	{
 		$img = $this->img;
 		$this->img = '/frontend/web/images/upload/item/' . $img;
 	}   
}
