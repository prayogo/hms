<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IdentificationType */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Identification Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->identificationtypeid]];
$this->params['breadcrumbs'][] = 'Update';
?>

<section class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
</section>


<section class="content">
    <div class="box box-default">
    	<?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
    </div>
</section>