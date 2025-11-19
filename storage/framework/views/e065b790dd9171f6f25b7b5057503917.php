<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
      <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" />
    <title><?php echo e(env('APP_NAME')); ?> ADMIN</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/vendorjs/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="shortcut icon" href="https://genfavicon.com/tmp/icon_a7bcb5f96c4ba95174d37e622a872f2b.ico" />

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/vendorjs/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    <link rel="stylesheet" href="/vendorjs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css?v=1" />
    <?php echo $__env->yieldContent('css'); ?>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin.css', 'resources/js/app.js']); ?>

</head>

<body class="sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <div class="nav-link">
                        |
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:MinhaConta.profile(<?php echo user()->id; ?>)">
                        <i class="fas fa-user"></i>
                    </a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
              -->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:  #432D65;">
            <!-- Brand Logo -->
            <a href="/admin" class="brand-link" style="display: flex; justify-content: center;text-decoration: none;">
                
                <span class="brand-text"><strong> PERGUNTAS </strong></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional)
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="/admin/temas" class="nav-link" style="color: #fff">
                                <i class="nav-icon fas fa-file-signature"></i>
                                <p>
                                    Temas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/scenarios" class="nav-link" style="color: #fff">
                                <i class="nav-icon fas fa-file-signature"></i>
                                <p>
                                    Cenários
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/games" class="nav-link" style="color: #fff">
                                <i class="nav-icon fas fa-gamepad"></i>
                                <p>
                                    Games
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/admin/app-usuarios" class="nav-link" style="color: #fff">
                                <i class="nav-icon fas fa-mobile"></i>
                                <p>
                                    Usuários do APP
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/usuarios" class="nav-link" style="color: #fff">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Usuários
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="nav-link" style="color: #fff">
                                <i class="nav-icon fa fa-power-off"></i>
                                <p>
                                    Sair
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-1 mt-2">
                        <div class="col-sm-6">
                            <?php echo $__env->yieldContent('module_title'); ?>
                        </div>
                    </div>
                </div>
            </section>

            <?php echo $__env->yieldContent('content'); ?>

        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer d-flex align-content-center justify-content-between">
            <div>Logado como: <b>
                    <?php echo user()->name; ?>
                </b>
               </div>
            <div>Copyright &copy;
                <?php echo date('Y'); ?> <strong><?php echo e(env('APP_NAME')); ?></strong>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>


    <!-- jQuery -->
    <script src="/vendorjs/jquery/jquery.min.js?v=<?php echo e(time()); ?>"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script src="/dist/js/services/service-notify.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/core/Validator.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/core/Money.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/core/ModalFactory.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/services/service-http.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/vendorjs/jquery.loadmask.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/vendorjs/jquery.price_format.2.0.min.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/vendorjs/jquery.maskedinput.min.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/vendorjs/jquery.serializejson.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/vendorjs/jquery.validate.min.js?v=<?php echo e(time()); ?>"></script>
    <script src="/vendorjs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js?v=<?php echo e(time()); ?>"></script>
    <script src="/vendorjs/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <script src="/dist/js/core/Utils.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/core/Config.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/modules/MinhaConta.js?v=<?php echo e(time()); ?>"></script>

    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js?v=<?php echo e(time()); ?>"></script>
    <!-- AdminLTE for demo purposes -->

    <?php echo $__env->yieldContent('js'); ?>
    <script src="/dist/js/admin.js?v=<?php echo e(time()); ?>"></script>

    
    

</body>

</html>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\Modules/Admin\Resources/views/layouts/master.blade.php ENDPATH**/ ?>