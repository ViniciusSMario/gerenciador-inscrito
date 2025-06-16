@props(['titlePage'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mb-2 navbar-light" id="navbarBlur" navbar-scroll="true">
    <div class="container">
        <nav aria-label="breadcrumb">
            <h6 class="font-weight-bolder mb-0">{{ $titlePage }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">

            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav justify-content-end">

                @php
                $hasUnreadNotifications = auth()->user()->unreadNotifications->isNotEmpty();
            @endphp

            <li class="nav-item mt-2 d-flex align-items-center">
                <a href="{{ route('notificacoes.notificacoes') }}" class="nav-link">
                    <i class="fa fa-bell cursor-pointer {{ $hasUnreadNotifications ? 'text-warning subtle-shake' : '' }}"></i>
                </a>
            </li>
            <li class="nav-item mt-2 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body font-weight-bold px-2">
                    <span class="d-sm-inline"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span class="material-icons text-danger">
                            power_settings_new
                        </span>
                    </span>
                </a>
            </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-2" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>

              
            </ul>
        </div>
    </div>
</nav>
{{-- <hr> --}}
<style>
    /* Animação de tremor suave com pausa de 1 minuto */
    @keyframes subtleShakeWithPause {

        0%,
        99.6% {
            transform: translate(0, 0);
        }

        /* Posição inicial e final para manter estático */
        1% {
            transform: translate(-1px, 0);
        }

        2% {
            transform: translate(1px, 0);
        }

        3% {
            transform: translate(-1px, 0);
        }

        4% {
            transform: translate(1px, 0);
        }

        5% {
            transform: translate(-1px, 0);
        }
    }

    /* Classe para aplicar o tremor suave */
    .fa-bell.subtle-shake {
        animation: subtleShakeWithPause 60s ease-in-out infinite;
        /* Animação com 1 minuto de intervalo */
    }
</style>
