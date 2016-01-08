<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

\yii\web\jQueryAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Hotel */

$this->title = 'Hotel Information';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
</section>

<section class="content">

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="glyphicon glyphicon-home"></i> Hotel Information</h3>
            <div class="box-tools pull-right">
                <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'name', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->name); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'city', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->city); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'state', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->state); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'locationid', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->location->name); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'email', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->email); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'phone1', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->phone1); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'phone2', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->phone2); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($model, 'fax', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->fax); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::activeLabel($model, 'address', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $model->address); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-calculator"></i> Tax Configuration</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($tax, 'room', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $tax->room . '%'); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($tax, 'meal', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $tax->meal . '%'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($tax, 'product', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $tax->product . '%'); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($tax, 'currency', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $tax->currency); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="glyphicon glyphicon-user"></i> Contact Person</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($contact, 'name', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $contact->name); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($contact, 'email', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $contact->email); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($contact, 'phone', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $contact->phone); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($contact, 'phone2', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $contact->phone2); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::activeLabel($contact, 'address', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $contact->address); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-bank"></i> Bank Information</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-6">
                    <?= Html::activeLabel($bank, 'name', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $bank->name); ?>
                </div>
                <div class="col-xs-6">
                    <?= Html::activeLabel($bank, 'accountno', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $bank->accountno); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= Html::activeLabel($bank, 'branch', ['class'=>'label-col']); ?>
                    <?= Html::label(': ' . $bank->branch); ?>
                </div>
            </div>
        </div>
    </div>

</section>

    



<style>
    .button-update{
        margin-left:0px !important;
        margin-top:10px;
    }
    .label-col{
        width:200px;
    }
    @media (min-width: 0px) and (max-width: 800px) {
        .col-xs-6 {
            float:none;
            width:100%;
        }
    }
    @media (min-width: 0px) and (max-width: 400px) {
        .label-col{
            width:100%;
        }
    }
    @media (min-width: 800px) and (max-width: 1024px) {
        .label-col{
            width:140px;
        }
    }
</style>