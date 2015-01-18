<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\icons\Icon;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        
        <?php

            NavBar::begin([
                'brandLabel' => "Dyva Hotel",
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    [
                        'label' => 'Home', 
                        'url' => ['/site/index'],
                    ],
                    isset(Yii::$app->user->identity->admin) && Yii::$app->user->identity->admin == "Y" ? 
                    [
                        'label' => 'Admin', 
                        'url' => ['#'], 
                        'items'=>[
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/hotel.png"/> Hotel Information', 
                                'url'=>['/hotel/index']],
                            
                            '<li class="divider"></li>',
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/equipment.png"/> Equipments', 
                                'url'=>['/equipment/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/floor.png"/> Floors', 
                                'url'=>['/floor/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/card.png"/> Identification Types', 
                                'url'=>['/identification-type/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/status.png"/> Room Status', 
                                'url'=>['/room-status/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/service.png"/> Service Items', 
                                'url'=>['/service-item/index']],
                            
                            '<li class="divider"></li>',
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/roomtype.png"/> Room Types', 
                                'url'=>['/room-type/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/room.png"/> Rooms', 
                                'url'=>['/room/index']],
                            
                            '<li class="divider"></li>',
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/user.png"/> Users Application', 
                                'url'=>['/user/index']],
                    ]] : '',
                    Yii::$app->user->isGuest ? '' :
                    [
                        'label' => 'Reservation', 
                        'url' => ['#'], 
                        'items'=>[
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/customer.png"/> Customers', 
                                'url'=>['/customer/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/reservation.png"/> Room Reservations', 
                                'url'=>['/room-reservation/index']],
                            [
                                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/payment.png"/> Payments', 
                                'url'=>['/payment/index']],
                        ]
                    ],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->fullname . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
                'encodeLabels' => false
            ]);
            NavBar::end();
        ?>
        

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Dyva Hotel <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
