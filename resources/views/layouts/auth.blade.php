<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventure</title>
    <link rel="shortcut icon" href="{{ asset('images/logo_white.png')}}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            padding-left: 0px !important;
        }

        .left-panel {
            background-color: #070b3b;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .left-panel img {
            max-width: 350px;
        }

        .right-panel {
            background-color: #fff;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #1da4fc;
            border: none;
        }

        .btn-primary:hover {
            background-color: #057ecf;
        }

        .toggle-password {
            cursor: pointer;
        }

        .forgot-password {
            color: #1da4fc;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .footer {
            font-size: 0.9rem;
            margin-top: 20px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row w-100 h-100">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function toggleConfirmPasswordVisibility() {
            const passwordField = document.getElementById('password-confirm');
            const toggleIcon = document.getElementById('toggle-password-confirm');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.getElementById('current-year').textContent = new Date().getFullYear();

    </script>
    
</body>

</html>
