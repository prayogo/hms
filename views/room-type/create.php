<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RoomType */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Room Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-type-create">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/roomtype.png"/>
        <span style="vertical-align: middle;">Room Types: <?= Html::encode($this->title) ?></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
