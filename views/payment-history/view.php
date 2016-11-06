<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detail Pembayaran';
$this->params['breadcrumbs'][] = ['label' => 'History Pembayaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

require_once('tcpdf_include.php');

?>

<section class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
</section>

<section class="content">
    <div style="position: relative;background: #fff;border: 1px solid #f4f4f4;padding: 20px;">
        <iframe src="<?= yii\helpers\Url::toRoute("/docs") ?>/PAYMENT-<?= $paymentid ?>.pdf" style="width:100%; height:400px"></iframe>
    </div>
</section>

