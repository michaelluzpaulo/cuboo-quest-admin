<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

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

    <?php echo $__env->yieldContent('css'); ?>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin.css', 'resources/js/app.js']); ?>
</head>

<body class="hold-transition skin-blue" style="background-color: #fff">
    <main class="wrapper">

        <div class="container" style="background-color: #fff">

            <h3 class="py-4"><?php echo e(env('APP_TITLE')); ?> GM</h3>

            <?php echo $estatistica; ?>



        <footer class="main-footer" style="margin-left: 0; text-align: center; padding: 10px 0;">
            Licenciado para
            <?php echo e(customer()->nome_fantasia); ?> - ©
            <?php echo e(date('Y')); ?> Copyright: <a target="_blank" href="https://www.n2.ag/" target="_blank">N2</a>

        </footer>
 </div>
    </main>
    <!-- ./wrapper -->

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
    <script src="/dist/js/core/Utils.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/core/Config.js?v=<?php echo e(time()); ?>"></script>
    <script src="/dist/js/modules/MinhaConta.js?v=<?php echo e(time()); ?>"></script>

    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js?v=<?php echo e(time()); ?>"></script>
    <!-- AdminLTE for demo purposes -->

    <?php echo $__env->yieldContent('js'); ?>
    <script src="/dist/js/admin.js?v=<?php echo e(time()); ?>"></script>

    <script type="text/javascript">
        setTimeout(() => {
            document.location.reload();
        }, 30000);

        $(document).ready(function() {
            Game.init2();
        });
    </script>
</body>

</html>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\quest_group\admin\Modules/Admin\Resources/views/layouts/master_gm.blade.php ENDPATH**/ ?>