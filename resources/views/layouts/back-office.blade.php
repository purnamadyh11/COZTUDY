<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('back-office') }}/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('back-office') }}/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('back-office') }}/fonts/ionicons.min.css">
  <link rel="stylesheet" href="{{ asset('back-office') }}/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="{{ asset('back-office') }}/dist/css/skins/_all-skins.min.css">
  <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<style>
  .table.dataTable.no-footer{
    border-bottom: 1px solid #e1e1e1;
  }
  .modal-full { 
    width: 80%;
    max-width: 80%;
    margin: auto;
  }

  .modal-full .modal-body {
    max-height: 700px;
    overflow-y: scroll
  }

  .mt-2{
    margin-top: 20px !important;
  }

  .ml-1{
    margin-left: 10px !important;
  }

  .detail{
    border: 2px dashed #dfe4ea
  }

  .preview-image {
      max-height: 200px;
      margin-bottom: 20px;
      border-radius: 10px;
  }

  .alert-cover{
    display: none
  }
</style>
<body class="hold-transition skin-purple sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">D<b>R</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Dashboard<b>Rental</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="/back-office/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/back-office/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/back-office/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}}
                  <small>Daftar sejak {{date('d-m-Y', strtotime(Auth::user()->created_at))}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  {{-- <a href="#" class="btn btn-default btn-flat">Profile</a> --}}
                </div>
                <div class="pull-right">
                  <a href="{{route('actionlogout')}}" class="btn btn-default btn-flat">Keluar</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/back-office/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/admin/place') }}"><i class="fa fa-circle-o"></i> Tempat</a></li>
          </ul>
          <ul class="treeview-menu">
            <li><a href="{{ url('/admin/rating') }}"><i class="fa fa-circle-o"></i> Rating</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
        <small>@yield('title-desc')</small>
      </h1>
      {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol> --}}
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        @yield('content')
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b><a href="http://www.fb.com/softsed">StudioProjectId V 1.0</a></b> 
    </div>
    <strong> <a href="http://almsaeedstudio.com">SPI</a></strong> 
  </footer>

  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset("back-office") }}/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('global/js/swal.js') }}"></script>
<script src="{{ asset("back-office") }}/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ asset("back-office") }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ asset("back-office") }}/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset("back-office") }}/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("back-office") }}/dist/js/demo.js"></script>
<script src="{{ asset("back-office") }}/ckeditor/ckeditor.js"></script>
<script src="{{ asset("global") }}/js/swal-helper.js"></script>
<script src="{{ asset("global") }}/js/rupiah.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  $('body').on('click', '.close-modal', function () {
      $('.modal').hide();
  });

  let currentUrl = window.location.href;

  $('li a').each(function() {
      let linkUrl = $(this).attr('href');
      if (currentUrl == linkUrl) {
        $(this).closest('li').addClass('active');
        $(this).parents().find('.treeview').addClass('active');
      }
  });
</script>

@stack('js')

</body>
</html>
