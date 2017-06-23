<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>拍拍哒 | 控制面板</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/ppd/Public//bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/ppd/Public//dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/ppd/Public//dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/ppd/Public//plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/ppd/Public//plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/ppd/Public//plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/ppd/Public//plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/ppd/Public//plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/ppd/Public//plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/ppd/Public//dist/css/loaders.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>拍拍哒</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="/ppd/Public//dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">拉普拉斯</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/ppd/Public//dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  拉普拉斯
                  <small>投资者</small>
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">

                <div class="pull-right">
                  <a href="../Public/logout" class="btn btn-default btn-flat">登出</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>


    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/ppd/Public//dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>拉普拉斯</p>
          <a href="#"><i class="fa fa-circle text-success"></i> 投资者</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">导航栏</li>
        <li>
            <a href="today">
            <i class="fa fa-dashboard"></i> <span>总览</span>
          </a>
        </li>
        <li>
          <a href="simulate">
            <i class="fa fa-th"></i> <span>新手模拟</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">推荐</small>
            </span>
          </a>
        </li>

        <li class="active">
          <a href="real">
            <i class="fa fa-pie-chart"></i> <span>投资专区</span>
          </a>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        总览
        <small>大厅</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">投资专区</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">




      <div class="row">

        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">所有选择</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>编号</th>
                  <th>借款金额</th>
                  <th>期数</th>
                  <th>利率</th>
                  <th>初始评级</th>
                  <th>操作</th>
                  <th>操作</th>

                </tr>
                </thead>
                <tbody class='zhcon'>
                    <tr class='list<?php echo ($data["ListingId"]); ?>'>
                      <td>
                    <div class="loadingsb" style="padding:50px 0 0px 30px;display:none;">
                      <div class="loader">
                          <div class="loader-inner ball-scale-multiple">
                            <div></div>
                            <div></div>
                            <div></div>
                            <p class="load" style="margin-left: 100px !important;padding-top:15px !important;font-size: 18px;">加载中...</p>
                          </div>
                      </div>
    </div></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>

                    </tr>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
      </div>
      <strong>©拉普拉斯团队</strong> 2017-2017
  </footer>


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="/ppd/Public//plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/ppd/Public//bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="/ppd/Public//plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/ppd/Public//plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/ppd/Public//plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/ppd/Public//plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/ppd/Public//dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/ppd/Public//dist/js/demo.js"></script>
<!-- This page's js -->
<script src="/ppd/Public//dist/js/real.js"></script>
<!-- page script -->
</body>
</html>