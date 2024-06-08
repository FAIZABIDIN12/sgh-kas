<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SATYA GRAHA HOTEL</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo-sgh.svg') }}" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <x-sidebar />
        <div class="body-wrapper">
            <x-header></x-header>
            <div class="container-fluid">
                {{$slot}}
            </div>
            <x-footer></x-footer>
        </div>
    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    {{ $scripts ?? '' }}
</body>

</html>