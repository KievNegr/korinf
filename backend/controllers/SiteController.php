<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;
use yii\helpers\Html;
use app\models\StaticPage;
use app\models\StaticCategory;
use app\models\ItemCategory;
use app\models\Item;
use app\models\Images;
use app\models\Tags;
use app\models\TagLinked;
use app\models\Newitem;
use app\models\NewCategory;
use app\models\IndexImg;
use app\models\Settings;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'logout'],
                        'allow' => true,
                    ],
                    [
                        //'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $settings = Settings::find()->all(); //Вытаскиваем все настройки
        $sitemap['items'] = Item::find()->all(); //Вытаскиваем все позиции товаров
        $sitemap['category'] = ItemCategory::find()->all(); //Вытаскиваем все существующие категории
        $sitemap['page'] = StaticPage::find()->all(); //Вытаскиваем все существующие страницы
        $sitemap['lastMod'] = 'Sitemap.xml отсутствует';

        if(yii::$app->request->post()) //Еси кнопка создать sitemap нажата то создаем новый sitemap
        {
            $newSitemap[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $newSitemap[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $newSitemap[] = '<url>';
            $newSitemap[] = '<loc>https://korinf-group.com/</loc>';
            $newSitemap[] = '<lastmod>' . date("Y-m-d") . '</lastmod>';
            $newSitemap[] = '</url>';

            foreach($sitemap['category'] as $categories)
            {
                $newSitemap[] = '<url>';
                $newSitemap[] = '<loc>https://korinf-group.com/equipment/' . $categories['sef'] . '.html</loc>';
                $newSitemap[] = '<lastmod>' . date("Y-m-d") . '</lastmod>';
                $newSitemap[] = '</url>';
            }

            $newSitemap[] .= '</urlset>';

            $file = fopen('../../frontend/web/sitemap-category.xml', 'w+t') or die('error');
            foreach($newSitemap as $newLine){
                fwrite($file, $newLine . "\r\n");
            }
            fclose($file);

            $newSitemap = Array();

            $newSitemap[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $newSitemap[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $newSitemap[] = '<url>';
            $newSitemap[] = '<loc>https://korinf-group.com/</loc>';
            $newSitemap[] = '<lastmod>' . date("Y-m-d") . '</lastmod>';
            $newSitemap[] = '</url>';

            foreach($sitemap['items'] as $item)
            {
                $newSitemap[] = '<url>';
                $newSitemap[] = '<loc>https://korinf-group.com/stat/' . $item['sef'] . '.html</loc>';
                $newSitemap[] = '<lastmod>' . date("Y-m-d") . '</lastmod>';
                $newSitemap[] = '</url>';
            }

            /*foreach($sitemap['page'] as $page)
            {
                $newSitemap[] = '<url>';
                $newSitemap[] = '<loc>https://korinf-group.com/' . $page['sef'] . '.html</loc>';
                $newSitemap[] = '</url>';
            }*/
            
            $newSitemap[] .= '</urlset>';
            
            //echo $newSitemap;
            //echo realpath('.');
            $file = fopen('../../frontend/web/sitemap-goods.xml', 'w+t') or die('error');
            foreach($newSitemap as $newLine){
                fwrite($file, $newLine . "\r\n");
            }
            fclose($file);
            /*echo '<pre>';
            print_r($newSitemap);
            echo '</pre>';*/
        }

        if(file_exists('../../frontend/web/sitemap.xml'))
            $sitemap['lastMod'] = date("d.m.Y H:m:i", filemtime('../../frontend/web/sitemap.xml'));

        return $this->render('settings', [
            'settings' => $settings,
            'sitemap' => $sitemap
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTags()
    {
        $tags = Tags::find()->all();

        $breadcrumbs[] = [
            'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
            'label' => 'Управление тегами'
        ];

        return $this->render('tags',[
            'breadcrumbs' => $breadcrumbs,
            'tags' => $tags,
        ]);
    }

    public function actionEquipment()
    {                
        /*-----------------Начинаем построение списка категорий-----------------------*/

        $items = NULL;

        $items = Item::find()->all();

        $allCategories = ItemCategory::find()->where(['sub_id' => NULL])->all(); //Вытаскиваем все родительские категории

        $allCategories = $this->getAllItem($allCategories);

        $breadcrumbs [] = [
            'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
            'label' => 'Управление каталогом оборудования'
        ];

        return $this->render('equipment', [
            'categories' => $allCategories,
            'breadcrumbs' => $breadcrumbs,
            'items' => $items,
        ]);
    }

    private function getAllItem($categories)
    {
        $arr = array();

        foreach($categories as $category)
        {
            $getChild = ItemCategory::find()->where(['sub_id' => $category->id])->all();
            
            if(count($getChild) > 0)
            {
                $arr[] = [$category->id, $category->name, $this->getAllItem($getChild)];
            }
            else
            {
                $arr[] = [$category->id, $category->name];
            }
        }

        return($arr);
    }

    public function actionEdititem($id)
    {
        $id = Html::encode($id);

        $item = Item::findOne($id);

        if(Yii::$app->request->isAjax)
        {
            $item->sef = Yii::$app->request->post('sef');
            $item->title = Yii::$app->request->post('title');
            $item->description = Yii::$app->request->post('description');
            $item->keywords = Yii::$app->request->post('keywords');
            $item->name = Yii::$app->request->post('name');
            $item->code = Yii::$app->request->post('code');
            $item->info = Yii::$app->request->post('info');
            $item->full_text = Yii::$app->request->post('fulltext');
            //$item->sef = Yii::$app->request->post('sef');
            //$item->save();
            return Yii::$app->request->post('category');
        }
        else
        {
            $gallery = Images::find()->where(['id_item' => $item->images])->all();

            $itemNameCategory = ItemCategory::findOne($item->category);

            $allCategories = ItemCategory::find()->where(['sub_id' => NULL])->all(); //Вытаскиваем все родительские категории

            $allCategories = $this->getAllItem($allCategories);

            $form = new IndexImg();

            if(Yii::$app->request->post())
            {
                $form->imageind = UploadedFile::getInstance($form, 'imageind');
                var_dump($form->imageind);
                //$form->imageind->saveAs('photo/' . $form->imageind->baseName);

                //echo 'aaaa';
                die();
            }

            $breadcrumbs [] = [
                'template' => '<li>{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Управление каталогом оборудования',
                'url' => ['equipment']
            ];

            $breadcrumbs [] = [
                'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
                'label' => $item->name
            ];

            return $this->render('item', [
                'item' => $item,
                'itemNameCategory' => $itemNameCategory,
                'gallery' => $gallery,
                'categories' => $allCategories,
                'breadcrumbs' => $breadcrumbs,
                'f' => $form
            ]);
        }
    }

    public function actionImages()
    {
        $fileName = 'file';
        $uploadPath = 'photo';

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);

            //Print file data
            print_r($file);

            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                //Now save file data to database

                echo \yii\helpers\Json::encode($file);
            }
        }

        //return false;
    }

    public function actionAdditem()
    {
        $form = new Newitem();

        if($form->load(Yii::$app->request->post()) && $form->validate())
        {
            $newItem = new Item();

            $form->img = UploadedFile::getInstance($form, 'img'); //Получаем массив инфы о картинке

            $nameImg = uniqid(); //Присваиваем уникальное имя картинке
            $form->img->saveAs('../../frontend/web/images/upload/item/' . $nameImg . '.' . $form->img->extension); //Сохраняем картинку
            
            copy('../../frontend/web/images/upload/item/' . $nameImg . '.' . $form->img->extension, '../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->img->extension);

            $form->saveImg($nameImg, $form->img, 'index');
            $img = $nameImg . '.' . $form->img->extension;

            $newItem->sef = $form->sef; //ЧПУ ccылка
            $newItem->title = $form->title; //Title страницы
            $newItem->description = $form->description; //Описание страницы
            $newItem->keywords = $form->keywords; //Ключевые слова страницы
            $newItem->name = $form->name; //Имя (Н1) страницы
            $newItem->price = $form->value; //Стоимость в евро
            $newItem->availability = $form->available; //Наличие
            $newItem->img = $img; //Главная картинка
            $newItem->category = $form->category; //Категория страницы
            $newItem->short_text = $form->short_text; //Категория страницы
            $newItem->code = $form->code; //Код (артикул) товара
            $newItem->info = $form->info; //Краткое описание страницы
            $newItem->full_text = $form->full_text; //Основной текст страницы

            if($newItem->save())
            {
                $imgId = $newItem->id; // ID созданой позиции
            }

            $tags = Tags::find()->all(); //Берем все теги

            $newTags = array();

            foreach($tags as $itemTag)
            {
                $newTags[$itemTag->id] = $itemTag->tag_name;
            }

            $inputTagsTemp = explode(',', $form->tags);

            foreach($inputTagsTemp as $strtoupper)
            {
                $strtoupper = trim($strtoupper);
                $inputTags[] = mb_strtoupper(mb_substr($strtoupper, 0, 1)) . mb_substr($strtoupper, 1);
            }

            $resultInputTags = array_unique($inputTags);

            foreach($resultInputTags as $it)
            {
                $key = array_search($it, $newTags);

                if($key == FALSE)
                {
                    $form->newTag($it, $imgId);
                }
                else
                {
                    $form->newTagLinked($key, $imgId);
                }
            }

            $saveImg = new Images();
            
            $form->saveImg($nameImg, $form->img, 'gallery');

            $saveImg->name = $nameImg . '.' . $form->img->extension;
            $saveImg->id_item = $imgId;

            $saveImg->save();

            $form->gallery1 = UploadedFile::getInstance($form, 'gallery1');
            $form->gallery2 = UploadedFile::getInstance($form, 'gallery2');
            $form->gallery3 = UploadedFile::getInstance($form, 'gallery3');
            $form->gallery4 = UploadedFile::getInstance($form, 'gallery4');
            $form->gallery5 = UploadedFile::getInstance($form, 'gallery5');
            $form->gallery6 = UploadedFile::getInstance($form, 'gallery6');

            if(!is_null($form->gallery1))
            {
                $saveImg = new Images();

                $nameImg = uniqid(); //Присваиваем уникальное имя картинке
                $form->gallery1->saveAs('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->gallery1->extension); //Сохраняем картинку
                $form->saveImg($nameImg, $form->gallery1, 'gallery');

                $saveImg->name = $nameImg . '.' . $form->gallery1->extension;
                $saveImg->id_item = $imgId;

                $saveImg->save();
            }

            if(!is_null($form->gallery2))
            {
                $saveImg = new Images();

                $nameImg = uniqid(); //Присваиваем уникальное имя картинке
                $form->gallery2->saveAs('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->gallery2->extension); //Сохраняем картинку
                $form->saveImg($nameImg, $form->gallery2, 'gallery');

                $saveImg->name = $nameImg . '.' . $form->gallery2->extension;
                $saveImg->id_item = $imgId;

                $saveImg->save();
            }

            if(!is_null($form->gallery3))
            {
                $saveImg = new Images();

                $nameImg = uniqid(); //Присваиваем уникальное имя картинке
                $form->gallery3->saveAs('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->gallery3->extension); //Сохраняем картинку
                $form->saveImg($nameImg, $form->gallery3, 'gallery');

                $saveImg->name = $nameImg . '.' . $form->gallery3->extension;
                $saveImg->id_item = $imgId;

                $saveImg->save();
            }

            if(!is_null($form->gallery4))
            {
                $saveImg = new Images();

                $nameImg = uniqid(); //Присваиваем уникальное имя картинке
                $form->gallery4->saveAs('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->gallery4->extension); //Сохраняем картинку
                $form->saveImg($nameImg, $form->gallery4, 'gallery');

                $saveImg->name = $nameImg . '.' . $form->gallery4->extension;
                $saveImg->id_item = $imgId;

                $saveImg->save();
            }

            if(!is_null($form->gallery5))
            {
                $saveImg = new Images();

                $nameImg = uniqid(); //Присваиваем уникальное имя картинке
                $form->gallery5->saveAs('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->gallery5->extension); //Сохраняем картинку
                $form->saveImg($nameImg, $form->gallery5, 'gallery');

                $saveImg->name = $nameImg . '.' . $form->gallery5->extension;
                $saveImg->id_item = $imgId;

                $saveImg->save();
            }

            if(!is_null($form->gallery6))
            {
                $saveImg = new Images();

                $nameImg = uniqid(); //Присваиваем уникальное имя картинке
                $form->gallery6->saveAs('../../frontend/web/images/upload/item/gallery/' . $nameImg . '.' . $form->gallery6->extension); //Сохраняем картинку
                $form->saveImg($nameImg, $form->gallery6, 'gallery');

                $saveImg->name = $nameImg . '.' . $form->gallery6->extension;
                $saveImg->id_item = $imgId;

                $saveImg->save();
            }
        }
        else
        {
            
            $settings = Settings::findAll([18, 19]); //Вытаскиваем шаблоны short_text и full_text
        
            $allCategories = ItemCategory::find()->where(['sub_id' => NULL])->all(); //Вытаскиваем все родительские категории

            $allCategories = $this->getAllItem($allCategories);

            $breadcrumbs [] = [
                'template' => '<li>{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Управление каталогом оборудования',
                'url' => ['equipment']
            ];

            $breadcrumbs [] = [
                'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Добавление оборудования'
            ];

            return $this->render('additem', [
                'categories' => $allCategories,
                'breadcrumbs' => $breadcrumbs,
                'form' => $form,
                'settings' => $settings,
            ]);
        }
    }

    public function actionAddcategory()
    {
        $form = new NewCategory;

        if($form->load(Yii::$app->request->post()) && $form->validate())
        {
            $newCategory = new ItemCategory();

            $form->img = UploadedFile::getInstance($form, 'img'); //Получаем массив инфы о картинке

            $nameImg = uniqid(); //Присваиваем уникальное имя картинке
            if($form->img != NULL)
            {
                $form->img->saveAs('../../frontend/web/images/menu/' . $nameImg . '.' . $form->img->extension);
                $form->saveImg($nameImg, $form->img);
                $img = $nameImg . '.' . $form->img->extension;
            } //Сохраняем картинку
            else
            {
                $img = 'template_menu.jpg';
            }

            $newCategory->sef = $form->sef; //ЧПУ ccылка
            $newCategory->title = $form->title; //Title
            $newCategory->description = $form->description; //Описание
            $newCategory->keywords = $form->keywords; //Ключевые слова
            $newCategory->name = $form->name; //Имя (Н1)
            $newCategory->img = $img; //Главная картинка
            if($form->category == 0)
            {
                $newCategory->sub_id = NULL;
            }
            else
            {
                $newCategory->sub_id = $form->category; //подкатегория
            }
            $newCategory->short_text = $form->short_text; //Короткий текст
            $newCategory->text = $form->full_text; //Основной текст

            if($newCategory->save())
            {
                $catId = $newCategory->id; // ID созданой позиции
            }

            $tags = Tags::find()->all(); //Берем все теги

            $newTags = array();

            foreach($tags as $itemTag)
            {
                $newTags[$itemTag->id] = $itemTag->tag_name;
            }

            $inputTagsTemp = explode(',', $form->tags);

            foreach($inputTagsTemp as $strtoupper)
            {
                $strtoupper = trim($strtoupper);
                $inputTags[] = mb_strtoupper(mb_substr($strtoupper, 0, 1)) . mb_substr($strtoupper, 1);
            }

            $resultInputTags = array_unique($inputTags);

            foreach($resultInputTags as $it)
            {
                $key = array_search($it, $newTags);

                if($key == FALSE)
                {
                    $form->newTag($it, $catId);
                }
                else
                {
                    $form->newTagLinked($key, $catId);
                }
            }
        }
        else
        {
            $allCategories = ItemCategory::find()->where(['sub_id' => NULL])->all(); //Вытаскиваем все родительские категории

            $allCategories = $this->getAllItem($allCategories);

            $breadcrumbs [] = [
                'template' => '<li>{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Управление каталогом оборудования',
                'url' => ['equipment']
            ];

            $breadcrumbs [] = [
                'template' => '<li class="active">{link}</li>', //  шаблон для этой ссылки  
                'label' => 'Добавление категории'
            ];

            return $this->render('addcategory', [
                'breadcrumbs' => $breadcrumbs,
                'form' => $form,
                'categories' => $allCategories,
            ]);
        }
    }

    public function actionPages()
    {
        $pages = StaticPage::find()->all();
        $categories = StaticCategory::find()->all();

        return $this->render('pages', [
            'pages' => $pages,
            'categories' => $categories
        ]);
    }
}