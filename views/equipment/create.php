<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Equipment */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipment-create">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/equipment.png"/>
        <span style="vertical-align: middle;">Equipments: <?= Html::encode($this->title) ?></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
