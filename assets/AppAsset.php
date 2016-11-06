<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'AdminLTE/css/ionicons.min.css',                //Ionicons
        'AdminLTE/css/AdminLTE.min.css',                //AdminLTE Theme
        'AdminLTE/css/skins/skin-red-light.min.css',
        'css/font-awesome/css/font-awesome.min.css'
    ];
    public $js = [
        'AdminLTE/js/app.min.js'
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
