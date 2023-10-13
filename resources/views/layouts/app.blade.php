<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CP') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fira+Mono:400" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic.min.css"
        integrity="sha512-LeCmts7kEi09nKc+DwGJqDV+dNQi/W8/qb0oUSsBLzTYiBwxj0KBlAow2//jV7jwEHwSCPShRN2+IWwWcn1x7Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.js"
        integrity="sha512-CTSrPIDxxtTdaIYlTKHEyvHa+70TOhC1pY3PLDgrUqCFifFtV7KrucZCvPy2K7hB0HtKgt0r4INTGBISqnaLNg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    {{-- Datatables Addons --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    {{-- Print This --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" integrity="sha512-d5Jr3NflEZmFDdFHZtxeJtBzk0eB+kkRXWFQqEc1EKmolXjHm2IKCA7kTvXBNjIYzjXfD5XzIjaaErpkZHCkBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body style="background-color:black !important">
    <div id="app">
        <nav class="navbar navbar-expand-lg bg-transparent">
            <div class="container-fluid">

                <div class="row w-100">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-8">
                                <a class="navbar-brand" href="#">Century Cardboard Box Factory & Printing Inc.</a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </div>
                            <div class="col-4 d-flex flex-columns align-items-xenter justify-content-end">
                                @guest
                                    <a href="{{ route('login') }}" type="button" class="btn btn-auth mx-5">Login</a>
                                    <a href="{{ route('login') }}" type="button" class="btn btn-auth2">Register</a>
                                @else
                                    <span class="welcome">Welcome {{ Auth::user()->lastname }}!</span>
                                    <a class="btn btn-auth mx-5" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    {{-- <button type="button" class="btn btn-auth mx-5">Logout</button> --}}
                                @endguest
                            </div>
                        </div>

                    </div>

                    <div class="col-12">
                        @guest
                        @else
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mt-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link nav-color" href="{{ route('index') }}">
                                            <span class="fa fa-home mr-2" aria-hidden="true"></span>
                                            Home
                                        </a>
                                    </li>
                                    @if (Auth::user()->roles !== 3)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('raw.index') }}">
                                                <span class="fa-solid fa-bars-staggered mr-2" aria-hidden="true"></span>
                                                Raw Materials
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('products.index') }}">
                                                <span class="fa fa-box-open mr-2" aria-hidden="true"></span>
                                                Products
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('inventory.index') }}">
                                                <span class="fa fa-box-open mr-2" aria-hidden="true"></span>
                                                Inventory
                                            </a>
                                        </li>
                                    @endif

                                    <li class="d-none nav-item dropdown d-none">
                                        <a class="nav-link dropdown-toggle" href="#realTimeCommunication" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false" id="navbarDropdown">
                                            <span class="fa fa-user mr-2" aria-hidden="true"></span>
                                            Real-Time Communication
                                        </a>
                                        <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                                            <li class="">
                                                <a class="dropdown-item" href="customers">
                                                    <span class="fa fa-user" aria-hidden="true"></span>
                                                    Customers & User Transactions
                                                </a>
                                            </li>
                                            <li class="">
                                                <a class="dropdown-item" href="real-time-communication">
                                                    <span class="fa fa-comment" aria-hidden="true"></span>
                                                    Real-time Communication
                                                </a>
                                            </li>
                                        </ul>

                                    </li>

                                    @if (Auth::user()->roles !== 3)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false" href="#warehouseManagement"
                                                id="navbarDropdown"aria-expanded="true">
                                                <span class="fa fa-box mr-2" aria-hidden="true"></span>
                                                Warehouse Management
                                            </a>

                                            <ul class="dropdown-menu " aria-labelledby="navbarDropdown"
                                                aria-expanded="false">
                                                <li class="">
                                                    <a class="dropdown-item" href="{{ route('warehouse.index') }}">
                                                        <span class="fa fa-warehouse mr-2" aria-hidden="true"></span>
                                                        Warehouse
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a class="dropdown-item"
                                                        href="{{ route('warehouse_inventory.index') }}">
                                                        <span class="fa fa-boxes-stacked mr-2" aria-hidden="true"></span>
                                                        Warehouse Inventory
                                                    </a>
                                                </li>

                                            </ul>

                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false" href="#activities" id="navbarDropdown">
                                                <span class="fa fa-bolt"></span>
                                                <span class="ml-2">Activities</span>
                                            </a>

                                            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                                                <li class="">
                                                    <a class="dropdown-item d-none" href="{{ route('purchase.index') }}">
                                                        <span class="fa fa-cart-shopping"></span>
                                                        <span class="ml-2">Purchase</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a class="dropdown-item" href="{{ route('produce.index') }}">
                                                        <span class="fa fa-thumbtack"></span>
                                                        <span class="ml-2">Produce</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a class="dropdown-item" href="sell">
                                                        <span class="fa fa-dollar-sign"></span>
                                                        <span class="ml-2">Sell</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false" href="#reports" id="navbarDropdown">
                                                <span class="fa fa-chart-line"></span>
                                                <span class="ml-2">Reports</span>
                                            </a>

                                            <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                                                <li class="">
                                                    <a class="dropdown-item" href="inventoryreport">
                                                        <span class="fa fa-warehouse"></span>
                                                        <span class="">Inventory Transactions</span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a class="dropdown-item" href="productreport">
                                                        <span class="fa fa-money-bill"></span>
                                                        <span class="">Product Transactions</span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </li>
                                    @endif

                                    @if (Auth::user()->roles == 1)
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false" href="#warehouseManagement"
                                                id="navbarDropdown"aria-expanded="true">
                                                <span class="fa fa-box mr-2" aria-hidden="true"></span>
                                                Management
                                            </a>

                                            <ul class="dropdown-menu " aria-labelledby="navbarDropdown"
                                                aria-expanded="false">
                                                <li class="">
                                                    <a class="dropdown-item" href="inventory">
                                                        <span class="fa fa-users mr-2" aria-hidden="true"></span>
                                                        Users
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a class="dropdown-item" href="{{ route('suppliers.index') }}">
                                                        <span class="fa fa-box mr-2" aria-hidden="true"></span>
                                                        Suppliers
                                                    </a>
                                                </li>
                                            </ul>

                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endguest

                    </div>

                </div>


            </div>
        </nav>

        <main class="py-3">
            @yield('content')
        </main>
    </div>
</body>


@if (Auth::check())
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/652520c1eb150b3fb99ff330/1hccgftfg';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
@endif

</html>
