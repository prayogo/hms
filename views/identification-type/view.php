<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\IdentificationType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Identification Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identification-type-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/card.png"/>
        <span style="vertical-align: middle;">Identification Types: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->identificationtypeid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->identificationtypeid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'name',
        ],
    ]) ?>

</div>
