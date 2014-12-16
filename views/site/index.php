<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Dyva Hotel';
?>
<div class="hotel-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/hotel.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>

<?php

    $model = \app\models\Hotel::find()->one();
    $tax = \app\models\Tax::find()->one();
    $contact = \app\models\ContactPerson::find()->one();
    $bank = \app\models\Bank::find()->one();

?>

    <h4><i class="glyphicon glyphicon-home"></i> Hotel Information</h4>
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


    <h4><i class="fa fa-calculator"></i> Tax Configuration</h4>
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

    <h4><i class="glyphicon glyphicon-user"></i> Contact Person</h4>
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


    <h4><i class="fa fa-bank"></i> Bank Information</h4>
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

<style>
    h4{
        border-bottom: 2px solid gray;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }
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