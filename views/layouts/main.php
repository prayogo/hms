<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\VendorAsset;
use kartik\icons\Icon;
use yii\helpers\Url;


/* @var $this \yii\web\View */
/* @var $content string */
VendorAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>


    <!--div class="wrap">
        
        <?php
/*
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

                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->fullname . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
                'encodeLabels' => false
            ]);
            NavBar::end();*/
        ?>
        
    </div-->


</body>




  <body class="hold-transition sidebar-mini layout-boxed skin-red-light">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?=\Yii::$app->request->BaseUrl?>/AdminLTE/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?=\Yii::$app->request->BaseUrl?>/AdminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <aside class="main-sidebar">

        <section class="sidebar">

          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?=\Yii::$app->request->BaseUrl?>/AdminLTE/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>

          <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <li><a href="<?= Url::toRoute('site/index') ?>"><i class="fa fa-link"></i> <span>Halaman Utama</span></a></li>

            <?php if (isset(Yii::$app->user->identity->admin) && Yii::$app->user->identity->admin == "Y"){ ?>
            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>Admin</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::toRoute('hotel/index') ?>">Informasi Hotel</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::toRoute('equipment/index') ?>">Fasilitas</a></li>
                <li><a href="<?= Url::toRoute('floor/index') ?>">Lantai</a></li>
                <li><a href="<?= Url::toRoute('identification-type/index') ?>">Tipe Identifikasi</a></li>
                <li><a href="<?= Url::toRoute('room-status/index') ?>">Status Kamar</a></li>
                <li><a href="<?= Url::toRoute('service-item/index') ?>">Produk Jual</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::toRoute('room-type/index') ?>">Tipe Kamar</a></li>
                <li><a href="<?= Url::toRoute('room/index') ?>">Kamar</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::toRoute('discount/index') ?>">Discount</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::toRoute('user/index') ?>">User Aplikasi</a></li>
              </ul>
            </li>
            <?php } ?>
                    
                            
            <?php if (!Yii::$app->user->isGuest){ ?>
            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>Reservasi Kamar</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="<?= Url::toRoute('customer/index') ?>">Pelanggan</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::toRoute('room-reservation/index') ?>">Reservasi</a></li>
                <li><a href="<?= Url::toRoute('payment/index') ?>">Pembayaran</a></li>
              </ul>
            </li>
            <?php } ?>

          </ul><!-- /.sidebar-menu -->

        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <?php $this->beginBody() ?>

        <?= $content ?>

        <?php $this->endBody() ?>

      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
  </body>
</html>
<?php $this->endPage() ?>

<style type="text/css">
    .divider{
        border-bottom: 1px solid #D6D6D6;
        margin-left: 5px !important;
        margin-right: 10px !important;
        margin-top: 2px !important;
        margin-bottom: 2px !important;
    }
    .select2-selection__rendered{
      margin-top: 1px !important
    }
</style>