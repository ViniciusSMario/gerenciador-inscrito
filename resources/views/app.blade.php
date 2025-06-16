<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar :activePage="$activePage"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth :titlePage="$titlePage"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container">
            @yield('content')
        </div>
    </main>
    @push('js')
    <script src="{{ asset('/js/plugins/chartjs.min.js') }}"></script>

    @endpush
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.phoneMask').mask('(00) 00000-0000');
        });

        $(document).ready(function(){
            $('.cpfMask').mask('000.000.000-00');
        });
    </script>
</x-layout>

