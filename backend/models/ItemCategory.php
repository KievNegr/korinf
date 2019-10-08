<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ItemCategory extends ActiveRecord
{
 	//public $img;

 	public function afterFind()
 	{
 		$img = $this->img;
 		$this->img = '/web/images/menu/' . $img;
 	}   
}
