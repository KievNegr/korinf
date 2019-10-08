<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use app\models\Tags;
use app\models\TagLinked;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Newitem extends Model
{
    public $sef; //ЧПУ ccылка
    public $title; //Title страницы
    public $description; //Описание страницы
    public $keywords; //Ключевые слова страницы
    public $name; //Имя (Н1) страницы
    public $value; //Стоимость в евро
    public $available; //доступность
    public $category; //Категория страницы
    public $short_text; //Категория страницы
    public $code; //Код (артикул) товара
    public $info; //Краткое описание страницы
    public $full_text; //Основной текст страницы
    public $tags; //Теги страницы
    public $img; //Основная картинка страницы
    public $gallery1; //Галерея картинок страницы
    public $gallery2; //Галерея картинок страницы
    public $gallery3; //Галерея картинок страницы
    public $gallery4; //Галерея картинок страницы
    public $gallery5; //Галерея картинок страницы
    public $gallery6; //Галерея картинок страницы

    public function rules()
    {
    	return [
    		[['sef', 'title', 'description', 'keywords', 'name', 'category', 'short_text', 'code', 'info', 'full_text', 'tags'], 'required'],
    		[['img'], 'image', 'extensions' => 'jpg, png'],
            ['value', 'default', 'value' => '0.00'],
            ['available', 'default', 'value' => '2'],
    		[['gallery1', 'gallery2', 'gallery3', 'gallery4', 'gallery5', 'gallery6'], 'image', 'extensions' => 'jpg, png'],
    	];
    }

    public function saveImg($nameImg, $img, $type)
    {
        switch ($type)
        {
            case 'index':
                $photo = Image::getImagine()->open('../../frontend/web/images/upload/item/' . $nameImg . '.' . $img->extension)->thumbnail(new box(351, 300))->save('../../frontend/web/images/upload/item/' . $nameImg . '.' . $img->extension); //Открываем нашу сохраненную картинку, изменяем размер и сохраняем

                $size = $photo->getSize(); //Получаем ее размеры
                echo $size;

                $ratio = $size->getWidth()/$size->getHeight();
                echo $ratio;

                if($ratio < 1.17) //Если соотношение сторон меньше чем надо то 
                {
                    $x = 175 - $size->getWidth() / 2;
                    Image::watermark('images/template_index.jpg', '../../frontend/web/images/upload/item/' . $nameImg . '.' . $img->extension, [$x, 0])->save('../../frontend/web/images/upload/item/' . $nameImg . '.' . $img->extension);
                }
                else
                {
                    $y = 150 - $size->getHeight() / 2;
                    Image::watermark('images/template_index.jpg', '../../frontend/web/images/upload/item/' . $nameImg . '.' . $img->extension, [0, $y])->save('../../frontend/web/images/upload/item/' . $nameImg . '.' . $img->extension);
                }
                break;

            case 'gallery':
                $photo = Image::getImagine()->open('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension)->thumbnail(new box(468, 400))->save('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension); //Открываем нашу сохраненную картинку, изменяем размер и сохраняем

                $size = $photo->getSize(); //Получаем ее размеры
                echo $size;

                $ratio = $size->getWidth()/$size->getHeight();
                echo $ratio;

                if($ratio < 1.17) //Если соотношение сторон меньше чем надо то 
                {
                    $x = 234 - $size->getWidth() / 2;
                    Image::watermark('images/template_gallery.jpg', '../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension, [$x, 0])->save('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension);
                }
                else
                {
                    $y = 200 - $size->getHeight() / 2;
                    Image::watermark('images/template_gallery.jpg', '../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension, [0, $y])->save('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension);
                }

                Image::getImagine()->open('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $img->extension)->thumbnail(new Box(120, 103))->save('../../frontend/web/images/upload/item/gallery/thumbs/' . $nameImg . '.' . $img->extension);
                break;
                
        }
    }

    public function newTag($name, $idItem)
    {
        $tag = new Tags();
        $linked = new TagLinked();

        $tag->tag_name = $name;

        if($tag->save())
        {
            $idTag = $tag->id; // ID созданого тега
        }

        $linked->id_tag = $idTag;
        $linked->id_item = $idItem;

        $linked->save();
    }

    public function newTagLinked($key, $idItem)
    {
        $linked = new TagLinked();

        $linked->id_tag = $key;
        $linked->id_item = $idItem;

        $linked->save();
    }
}
