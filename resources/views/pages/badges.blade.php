@auth
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Badge Printing</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="shortcut icon" type="image/png" href="{{asset('images/icons/Badar-icon-128x128.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,700&amp;family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&amp;display=swap">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/badge.css') }}">
    <style>

    </style>
</head>

<body class="antialiased">
    <div class="container-fluid">
        <div class="operationClass">
            <br />
            <div class="row">
                <div class="btn-parent d-flex justify-content-center">
                    <button class="btn btn-outline-primary" onclick="window.print()">Print this E-badge</button>
                </div>
            </div>
            <br />
            <br />
        </div>
        @foreach ($data as $key=> $node)
        <x-badge :componentKey="$key" :badgeData="$node" />
        @endforeach
    </div>

    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" type="text/javascript">
    </script>
    <script type="text/javascript" src="{{ asset('assets/jquery/jquery-barcode.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/badge.js') }}"></script>
</body>

</html>
@endauth