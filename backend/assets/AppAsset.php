<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Exo+2:400,600,700|Roboto:300,400,700|Open+Sans+Condensed:300,700|Open+Sans:400,700',
        'css/style.css',
        'css/slider.css',
    ];
    public $js = [
        //'https://code.jquery.com/jquery-3.2.0.min.js',
        'js/korinf.js',
        'js/jquery.ajax.upload.js',
    ];
    /*public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/
}
