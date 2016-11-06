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
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@vendor';
    public $css = [
        'bower/select2/dist/css/select2.min.css'
    ];
    public $js = [
        'bower/select2/dist/js/select2.min.js'
    ];
    public $depends = [
        //'yii\bootstrap\BootstrapAsset',
    ];
}
