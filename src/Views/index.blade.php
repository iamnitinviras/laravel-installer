<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Creativeitem Software Installation" />
    <meta name="author" content="Creativeitem" />
    <title>{{ __('Installation') . ' | ' . __('Academy Laravel') }}</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- End meta -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="page-body">

    <div class="page-container horizontal-menu">

        <header class="navbar navbar-fixed-top ins-one bg-dark">
            <div class="container py-2 text-center justify-content-center">
                <span class="logo_name ms-4 text-secondary">{{ __('Installation') }}</span>
            </div>
        </header>
        <div class="main_content container py-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
