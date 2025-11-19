<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Canal Ouvidoria</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">



    <link rel="stylesheet" href="/dist/css/site.css">


    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>


    <header style="background-color: {{ $empresa->cor }}">
        <section class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="logo">
                        <img src="https://canal-ouvidoria.com.br/storage/empresa/big_{{ $empresa->img }}"
                            alt="{{ $empresa->nome }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-12">
                    <h1>Denúncia/Comunicação</h1>
                </div>
            </div>
        </section>
    </header>
    <main>
        @yield('content')
    </main>
    <footer style="background-color: {{ $empresa->cor }}">
        <p>
            © {{ date('Y') }} | {{ $empresa->nome }}
        </p>
    </footer>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="/dist/js/services/service-notify.js?v={{ time() }}"></script>
    <script src="/dist/js/core/Validator.js?v={{ time() }}"></script>
    <script src="/dist/js/core/ModalFactory.js?v={{ time() }}"></script>
    <script src="/dist/js/services/service-http.js?v={{ time() }}"></script>
    <script src="/dist/js/vendorjs/jquery.loadmask.js?v={{ time() }}"></script>
    <script src="/dist/js/vendorjs/jquery.maskedinput.min.js?v={{ time() }}"></script>
    <script src="/dist/js/vendorjs/jquery.serializejson.js?v={{ time() }}"></script>
    <script src="/dist/js/vendorjs/jquery.validate.min.js?v={{ time() }}"></script>
    <script src="/dist/js/core/Utils.js?v={{ time() }}"></script>
    <script src="/dist/js/core/Config.js?v={{ time() }}"></script>



    @yield('js')
    <script src="/dist/js/site/Interacoes.js?v={{ date('YmdHis') }}"></script>
    {{-- <script src="/js/site/app.js?v={{ date('YmdHis') }}"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
            Interacoes.init();
        });
    </script>

</body>

</html>
