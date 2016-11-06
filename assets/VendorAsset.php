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
        'bower/bootstrap/dist/css/bootstrap.min.css',
        'bower/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'bower/datatables.net-bs/css/dataTables.bootstrap.min.css'
    ];
    public $js = [
        'bower/bootstrap/dist/js/bootstrap.min.js',
        'bower/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
        'bower/moment/moment.js',
        'bower/datatables.net/js/jquery.dataTables.min.js',
        'bower/datatables.net-bs/js/dataTables.bootstrap.min.js'
    ];
    public $depends = [
        //'yii\bootstrap\BootstrapAsset',
    ];
}
