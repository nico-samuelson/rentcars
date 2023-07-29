<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">Rentcars<span class='text-primary'>.id</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item me-5">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">HOME</a>
                </li>
                <li class="nav-item me-5">
                    <a class="nav-link {{ Request::is('about/*') ? 'active' : '' }}" href="/about">ABOUT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('rent/*') ? 'active' : '' }}" href="/rent/schedule">RENT</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ Request::is('user/*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class='dropdown-item mb-2 {{ Request::is('user/profile/*') ? 'active' : '' }}' href='{{ route('user.profile') }}'>Profile</a></li>
                        <li><a class="dropdown-item mb-2 {{ Request::is('user/booking/*') ? 'active' : '' }}" href="{{ route('user.bookings') }}">My Bookings</a></li>
                        <li>
                            <form action="/logout" method="POST" class="m-0 p-0 w-100">
                                @csrf
                                <button class='btn nav-link ms-2 w-100 d-flex justify-content-start align-items-center'><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                
                @else
                    <li class="nav-item my-2 my-lg-0">
                        <a class="text-light btn btn-primary px-4 {{ Request::is('login') ? 'active' : '' }}" href="/login">SIGN IN</a>
                    </li>
                @endauth
            </ul>

                
            </ul>
        </div>
    </div>
</nav>