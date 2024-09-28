<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title></title>

    <link rel="icon" type="image/x-icon" href="{{asset('/favicon.ico')}}" />
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{asset('css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/fontawesome.css')}}" rel="stylesheet" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('css/toastify.min.css')}}" rel="stylesheet" />


    <link href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css')}}" rel="stylesheet" />

    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <script src="{{asset('js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>


    <script src="{{asset('js/toastify-js.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>


</head>

<body>

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <nav class="navbar fixed-top px-0 shadow-sm bg-white" style="height:68px">
        <div class="container-fluid align-items-center">

            <a class="navbar-brand" href="#">
                <span class="icon-nav m-0 h5" onclick="MenuBarClickHandler()">
                    <img class="nav-logo-sm mx-2" src="{{ asset('images/menu.svg') }}" alt="logo" />
                </span>
                <img class="nav-logo" src="{{ asset('images/imagesC.png') }}" alt="logo" style="width:80px;height:37px" />
            </a>

            <div class="d-flex justify-content-center flex-grow-1">
                <!-- Filter Form -->
                <form class="d-flex d-none d-lg-flex" method="GET" action="{{route('home')}}">
                    <!-- Filter Dropdowns -->
                    <div class="me-2 w-20 mt-1 mb-1">
                        <select class="form-select type" name="car_type" id="car_type1" aria-label="Car Type">
                            <option value="">CarType</option>
                        </select>
                    </div>

                    <div class="me-2 w-20 mt-1 mb-1">
                        <select class="form-control carBrand" name="brand" aria-label="Brand">
                            <option value="">Brand</option>
                        </select>
                    </div>

                    <div class="me-2 w-20 mt-1 mb-1">
                        <input class="form-control" type="number" name="min_price" placeholder="Min Price" aria-label="Min Price">
                    </div>

                    <div class="me-2 w-20 mt-1 mb-1">
                        <input class="form-control" type="number" name="max_price" placeholder="Max Price" aria-label="Max Price">
                    </div>

                    <button class="btn btn-outline-primary mt-1 mb-1" type="submit">Filter</button>
                </form>
            </div>
            <div class="float-right h-auto d-flex">
                @if(session('user_id'))
                <div class="float-right h-auto d-flex">
                    <div class="user-dropdown">
                        <img class="icon-nav-img" src="{{ asset('images/user.webp') }}" alt="" />
                        <div class="user-dropdown-content ">
                            <div class="mt-4 text-center">
                                <img class="icon-nav-img" src="{{ asset('images/user.webp') }}" alt="" />
                                <div class="userName text-center">
                                    @yield("title")
                                </div>
                                <hr class="user-dropdown-divider  p-0" />
                            </div>
                            <a href="{{ url('/userProfile') }}" class="side-bar-item">
                                <span class="side-bar-item-caption">Profile</span>
                            </a>
                            <a href="{{ url('/logout') }}" class="side-bar-item">
                                <span class="side-bar-item-caption">Logout</span>
                            </a>
                        </div>
                    </div>
                    @else
                    <a href="{{ url('/userLogin') }}">
                        <h6>Login</h6>
                    </a>
                    <a href="{{ url('/userRegistration') }}" class="ms-3">
                        <h6>Register</h6>
                    </a>
                </div>
                @endif

            </div>

        </div>
    </nav>

    <!-- Sidebar for Navigation, Filters, and Profile -->
    <div id="sideNavRef" class="side-nav-open">
        <a href="{{ url('/home') }}" class="side-bar-item">
            <i class="bi bi-graph-up"></i>
            <span class="side-bar-item-caption">Home</span>
        </a>
        <a href="{{ url('/about') }}" class="side-bar-item">
            <i class="bi bi-people"></i>
            <span class="side-bar-item-caption">About</span>
        </a>
        <a href="{{ url('/contact') }}" class="side-bar-item">
            <i class="bi bi-list-nested"></i>
            <span class="side-bar-item-caption">Contact</span>
        </a>
        <a href="{{ url('/customerRentalPage') }}" class="side-bar-item">
            <i class="bi bi-list-nested"></i>
            <span class="side-bar-item-caption">Rental History</span>
        </a>

        <div class="sidebar-filters d-lg-none">
            <h5>Filters</h5>
            <form class="d-flex flex-column" method="GET" action="{{route('home')}}">
                <div class="mb-2">
                    <select class="form-select type" name="car_type" aria-label="Car Type">
                        <option value="">CarType</option>
                    </select>
                </div>

                <div class="mb-2">
                    <select class="form-control carBrand" name="brand" aria-label="Brand">
                        <option value="">Brand</option>
                    </select>
                </div>

                <div class="mb-2">
                    <input class="form-control" type="number" name="min_price" placeholder="Min Price" aria-label="Min Price">
                </div>

                <div class="mb-2">
                    <input class="form-control" type="number" name="max_price" placeholder="Max Price" aria-label="Max Price">
                </div>

                <button class="btn btn-outline-primary" type="submit">Filter</button>
            </form>
        </div>



    </div>

    <div id="contentRef" class="content">
        @yield('content')
    </div>



    <script>
        getTypeOption();
        getBrandOption();

        function MenuBarClickHandler() {
            let sideNav = document.getElementById('sideNavRef');
            let content = document.getElementById('contentRef');
            if (sideNav.classList.contains("side-nav-open")) {
                sideNav.classList.add("side-nav-close");
                sideNav.classList.remove("side-nav-open");
                content.classList.add("content-expand");
                content.classList.remove("content");
            } else {
                sideNav.classList.remove("side-nav-close");
                sideNav.classList.add("side-nav-open");
                content.classList.remove("content-expand");
                content.classList.add("content");
            }
        }

        async function getTypeOption() {
            try {

                const response = await axios.get('/carTypes');
                const data = response.data;
                const selects = document.querySelectorAll('.form-select.type');


                selects.forEach(select => {
                    select.innerHTML = '<option value="">Select Car Type</option>';
                });


                data.forEach(carType => {
                    selects.forEach(select => {
                        const option = document.createElement('option');
                        option.value = carType.car_type;
                        option.text = carType.car_type;
                        select.appendChild(option);
                    });
                });
            } catch (error) {
                console.error('Error fetching car types:', error);
            }
        }

        async function getBrandOption() {
            try {

                const response = await axios.get('/carBrands');
                const data = response.data;
                const selects = document.querySelectorAll('.form-control.carBrand');


                selects.forEach(select => {
                    select.innerHTML = '<option value="">Select Brand</option>';
                });


                data.forEach(carBrand => {
                    selects.forEach(select => {
                        const option = document.createElement('option');
                        option.value = carBrand.brand;
                        option.text = carBrand.brand;
                        select.appendChild(option);
                    });
                });
            } catch (error) {
                console.error('Error fetching car types:', error);
            }
        }
    </script>

</body>

</html>


</body>

</html>