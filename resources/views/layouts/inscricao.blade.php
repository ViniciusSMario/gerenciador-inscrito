<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #094b83, #070b3b);
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .container {
            /* max-width: 400px; */
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        h1 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #094b83;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #094b83;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .btn-success {
            background-color: #1da4fc;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-success:hover {
            background-color: #094b83;
            transform: scale(1.05);
        }

        .text-muted {
            font-size: 0.9rem;
            text-align: center;
        }

        .link-muted {
            color: #1da4fc;
            text-decoration: none;
        }

        .link-muted:hover {
            color: #094b83;
            text-decoration: underline;
        }

        .icon-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .icon-container i {
            font-size: 3rem;
            color: #1da4fc;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        @yield('content')
    </div>
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.phoneMask').mask('(00) 00000-0000');
            $('.cpfMask').mask('000.000.000-00');

        });
        document.addEventListener('DOMContentLoaded', function() {
            console.log('aui')
            const elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });
    </script>
</body>

</html>
