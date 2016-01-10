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
class VendorAsset extends AssetBundle
{
    public $sourcePath = '@vendor';
    public $css = [
        'bower/bootstrap/dist/css/bootstrap.min.css'
    ];
    public $js = [
        'bower/bootstrap/dist/js/bootstrap.min.js'
    ];
    public $depends = [
        //'yii\bootstrap\BootstrapAsset',
    ];
}
