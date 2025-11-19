<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(env('APP_NAME')); ?> - AUTH</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin.css']); ?>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-login login shadow-sm">
            <div class="container">

                <a class="navbar-brand m-auto" href="<?php echo e(url('/')); ?>" style="text-decoration: none;">
                    <span class="brand-text"
                        style="color: #fff;text-transform:uppercase"><strong></strong><?php echo e(env('APP_TITLE')); ?></span>
                    <!--
                    <img src="/img/logo.png" style="height: 70px"
                        alt="imagem com a logo escrita de sindicato das empresas de asseio, conservação e serviços terceirizados do estado de Santa Catarina">-->
                    
                </a>

            </div>
        </nav>

        <main class="login_content">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>

</html>
<?php /**PATH D:\work\www\bkp_2024\cuboo_group\jogo_perguntas\admin\resources\views/layouts/app.blade.php ENDPATH**/ ?>