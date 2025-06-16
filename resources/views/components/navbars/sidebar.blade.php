@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header d-flex justify-content-center">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand text-center m-0 d-flex text-wrap align-items-center"
            href=" {{ route('dashboard.index') }} ">
            <img src="{{ asset('images/logo_white.png') }}" class="navbar-brand-img img-fluid" alt="Logo Eventure">
            <span class="ms-2 font-weight-bold text-white">Eventure</span>
        </a>
    </div>
    <p class="text-center text-white">Olá, <?= Auth::user()->name ?></p>
    {{-- <hr class="horizontal light mt-0 mb-2"> --}}
    <div class="" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('dashboard.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'eventos' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('eventos.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">event</i>
                    </div>
                    <span class="nav-link-text ms-1">Eventos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'inscritos' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('inscritos.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Inscritos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'clientes' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('clientes.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">assignment_ind</i>
                    </div>
                    <span class="nav-link-text ms-1">Clientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'tickets' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('tickets.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;"
                            class="material-icons ps-2 pe-2 text-center">confirmation_number</i>
                    </div>
                    <span class="nav-link-text ms-1">Tickets</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'calendario' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('calendario.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">event_note</i>
                    </div>
                    <span class="nav-link-text ms-1">Calendário</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'notificacoes' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('notificacoes.notificacoes') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notificações</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'mercadopago' ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('mercadopago.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="material-icons ps-2 pe-2 text-center">credit_card</i>
                    </div>
                    <span class="nav-link-text ms-1">Gateway Pagamento</span>
                </a>
            </li>

        </ul>
    </div>
    <p class="mt-5 text-center text-white" style="font-size: 14px">
        Desenvolvido por InovaFlow<br> &copy; Todos os direitos reservados
    </p>

</aside>
