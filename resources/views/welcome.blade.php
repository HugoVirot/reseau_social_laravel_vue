<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réseau Social Laravel</title>
    <meta name="description" content="Découvrez le réseau social Laravel ! Discutez avec vos amis.">
    <script src="https://kit.fontawesome.com/6259f9b52f.js" crossorigin="anonymous"></script>

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">    <login /></div> <!-- le front-end Vue JS est injecté ici -->
    {{-- <script>
        window.Laravel = <?php //echo json_encode([
        //  'csrfToken' => csrf_token()
        //  ]);
        ?>
    </script> --}}
</body>

</html>
