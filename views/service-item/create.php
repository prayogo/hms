<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ServiceItem */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Service Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-item-create">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/service.png"/>
        <span style="vertical-align: middle;">Service Items: <?= Html::encode($this->title) ?></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
