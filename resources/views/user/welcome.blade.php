@extends('user.layouts.main')

@section('style')
    <style>
        .landing {
            background: url("/website-assets/landing-bg.png") no-repeat;
            background-size: contain;
            background-position-x: 50%;
        }
        
        .landing img {
            margin-top: 5em !important;
            width: 75%;
            border-radius: 20px;
        }

        @media screen and (max-width: 576px) {
            body {
                background: #000;
            }

            .landing img {
                margin-top: 7em !important;
                width: 100%;
            }
        }

        .why-us-card > div {
            min-height: 50vh !important;
        }
        
        .why-us-icon {
            width: 3em;
            aspect-ratio : 1/1;
            border-radius: 10pt;
        }

        .cars {
            scroll-snap-type: x mandatory; 
            white-space: nowrap; 
            overflow-x: auto;
        }
        
        .car {
            scroll-snap-align: end;
        }
        
        .car figure {
            height: 35vh;
            border-radius: 20pt !important;
        }

        .prev:hover, .next:hover {
            background-color: var(--primary) !important;
        }

        .prev:focus, .next:focus {
            background-color: var(--primary) !important;
            border: 2px solid transparent !important;
        }

        .form-control {
            color: #fff !important;
        }

        .input-group .form-control {
            background-color: transparent !important;
            border: none !important;
            border-bottom: 1px solid #888 !important;
            border-radius: 0 !important;
        }

        textarea {
            background-color: transparent !important;
            border: 1px solid #888 !important;
            border-radius: .375rem !important;
        }

        .input-group .form-control:focus {
            border-bottom: 1px solid var(--primary) !important;
        }

        textarea:focus {
            border: 1px solid var(--primary) !important;
        }

        .cars::-webkit-scrollbar {
            height: 7px;
        }

        .toast {
            bottom: 20px;
            z-index: 5001;
        }

        .footer {
            border-top: 1px solid #88888850 !important;
        }

        @media screen and (max-width:992px) {
            .why-us-card > div {
                border-radius: 20pt !important;
                min-height: 35vh !important;
                margin-bottom: 50px;
            }

            .why-us-icon {
                width: 60px;
            }

            .why-us-icon img {
                width: 30px;
            }

            .cars-container {
                overflow-x: hidden;
            }

            .cars > div {
                scroll-snap-align: start;
            }

            .car figure {
                height: 15vh !important;
            }

            .cars::-webkit-scrollbar {
                display: none;
            }
        }

        @media screen and (max-width:768px) {
            .why-us-card > div {
                border-radius: 20pt !important;
                min-height: 40vh !important;
                margin-bottom: 50px;
            }

            .why-us-icon {
                width: 60px;
            }

            .why-us-icon img {
                width: 30px;
            }

            .cars-container {
                overflow-x: hidden;
            }

            .cars > div {
                scroll-snap-align: start;
            }

            .cars::-webkit-scrollbar {
                display: none;
            }

            .car figure {
                height: 25vh !important;
            }
        }

        .rent-prompt {
            --primary-color: transparent;
            --secondary-color: #fff;
            --hover-color: #111;
            --arrow-width: 10px;
            --arrow-stroke: 2px;
            box-sizing: border-box;
            border: 0;
            border-radius: 20px;
            color: var(--secondary-color);
            padding: 1em 1.8em;
            background: var(--primary-color);
            display: flex;
            transition: 0.2s background;
            align-items: center;
            gap: 0.6em;
            font-weight: bold;
        }

        .rent-prompt .arrow-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .rent-prompt .arrow {
            margin-top: 1px;
            width: var(--arrow-width);
            background: var(--primary-color);
            height: var(--arrow-stroke);
            position: relative;
            transition: 0.2s;
        }

        .rent-prompt .arrow::before {
            content: "";
            box-sizing: border-box;
            position: absolute;
            border: solid var(--secondary-color);
            border-width: 0 var(--arrow-stroke) var(--arrow-stroke) 0;
            display: inline-block;
            top: -3px;
            right: 3px;
            transition: 0.2s;
            padding: 3px;
            transform: rotate(-45deg);
        }

        .rent-prompt:hover {
            background-color: var(--hover-color);
        }

        .rent-prompt:hover .arrow {
            background: var(--secondary-color);
        }

        .rent-prompt:hover .arrow:before {
            right: 0;
        }
    </style>
@endsection

@section('container')
    {{-- Landing --}}
    <header class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center landing text-center p-0 m-0">
            <div class="col-12 mt-5 justfiy-content-center" data-aos="fade-right" data-aos-once='true' data-aos-duration="1000" data-aos-anchor-placement='top-center'>
                <h1 class='mt-5 mb-4'>Drive Your Way</h1>
                <h5 class='mb-4 text-muted'>Rent any car with affordable prices anywhere in Indonesia</h5>
                <a href="{{ route('rent-schedule') }}" class="btn btn-primary mt-4 px-5 py-3">Get Started</a>
            </div>
            <img src="/website-assets/banner.webp" alt="Banner">
        </div>
    </header>
    
    <main class="container">
        {{-- Why Us Section --}}
        <div class="row d-flex justify-content-center align-items-center why-us mt-5">
            <div class="col-12 my-5">
                <h2 class='text-center'>Why Us</span></h2>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 px-4 why-us-card" data-aos="zoom-in" data-aos-once='true' data-aos-duration="750" data-aos-anchor-placement='center-bottom'>
                <div class="p-5 tile mb-0 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-4 p-0">Affordable Price</h5>
                        <p class="p-0">With over than 10 partners available, we always make sure to give you the best price for your journey</p>
                    </div>

                    <div class="row ps-2">
                        <div class="col-3 p-3 rounded d-flex justify-content-center" style="background-color:#B9186C">
                            <img src="storage/website-assets/Price.png" alt="Price Tag" width="30px">
                        </div>
                        <div class="col-9 p-0 d-flex align-items-center justify-content-end">
                            <a href="{{ route('rent-schedule') }}" class="text-decoration-none">
                                <button class="rent-prompt">
                                    RENT NOW
                                    <div class="arrow-wrapper">
                                        <div class="arrow"></div>
                                    </div>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 px-4 why-us-card" data-aos="zoom-in" data-aos-once='true' data-aos-duration="750" data-aos-anchor-placement='center-bottom'>
                <div class="p-5 tile mb-0 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-4 p-0">We care about you</h5>
                        <p class="p-0">Our customer support is always ready to help you throughout your journey</p>
                    </div>

                    <div class="row ps-2">
                        <div class="col-3 p-3 rounded d-flex justify-content-center" style="background-color:#2B47B7">
                            <img src="storage/website-assets/Support Service.png" alt="Top Quality Cars" width="30px">
                        </div>
                        <div class="col-9 p-0 d-flex align-items-center justify-content-end">
                            <a href="{{ route('rent-schedule') }}" class="text-decoration-none">
                                <button class="rent-prompt">
                                    RENT NOW
                                    <div class="arrow-wrapper">
                                        <div class="arrow"></div>
                                    </div>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4 px-4 why-us-card" data-aos="zoom-in" data-aos-once='true' data-aos-duration="750" data-aos-anchor-placement='center-bottom'>
                <div class="p-5 tile mb-0 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-4 p-0">Quality Vehicles</h5>
                        <p class="p-0">
                            With the help of our quality assurance team, we make sure every vehicle is ready for you to use
                        </p>
                    </div>

                    <div class="row ps-2">
                        <div class="col-3 p-3 rounded d-flex justify-content-center" style="background-color:#6246EA">
                            <img src="storage/website-assets/Support Service.png" alt="Top Quality Cars" width="30px">
                        </div>
                        <div class="col-9 p-0 d-flex align-items-center justify-content-end">
                            <a href="{{ route('rent-schedule') }}" class="text-decoration-none">
                                <button class="rent-prompt">
                                    RENT NOW
                                    <div class="arrow-wrapper">
                                        <div class="arrow"></div>
                                    </div>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fleet Section --}}
        <div class="row d-flex justify-content-center align-items-center my-5 px-3">
            <h2 class='text-center my-5'>Our Fleet</h2>

            <div class="col-md-6 d-flex justify-content-center">
                <form method="POST" class="w-100">
                    @csrf
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-3 col-3 px-lg-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="all" autocomplete="off" value='all' checked>
                            <label class="btn m-0 w-100 text-muted border-dark" for="all">
                                All
                            </label>
                        </div>

                        <div class="col-lg-3 col-3 px-lg-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="luxury" autocomplete="off" value='Luxury' checked>
                            <label class="btn btn-primary m-0 w-100 border-dark" for="luxury">
                                Luxury
                            </label>
                        </div>

                        <div class="col-lg-3 col-3 px-lg-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="family" autocomplete="off" value='Family'>
                            <label class="btn m-0 w-100 text-muted border-dark" for="family">
                                Family
                            </label>
                        </div>

                        <div class="col-lg-3 col-3 px-lg-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="minibus" autocomplete="off" value='Minibus'>
                            <label class="btn m-0 w-100 text-muted border-dark" for="minibus">
                                Minibus
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center justify-content-center cars-container">
                <div class="row flex-nowrap cars mb-3">
                    @foreach($cars as $car)
                        <div class="col-md-4 col-sm-6 col-11 m-0 p-3 car">
                            <figure class="figure bg-dark p-4 rounded d-flex justify-content-center align-items-center">
                                <img src="{{ $car->vehicle_image }}" class="figure-img img-fluid rounded d-flex justify-content-center align-items-center" alt="{{ $car->brand . ' ' . $car->model }}">
                            </figure>
                            <p class="text-light mt-1 mb-0">{{ $car->brand . ' ' . $car->model }}</p>
                            <span class="badge text-light fw-normal d-flex align-items-center justify-content-start">
                                <img src="/website-assets/people.png" alt="" height="25px">
                                <span class="ps-2 fs-6">{{ ' ' . $car->capacity}}</span>
                                <img src="/website-assets/Baggage.png" alt="" height="25px" class="ps-3">
                                <span class="ps-2 fs-6">{{ ' ' . $car->trunk }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-center mt-md-3">
                <button class="btn border-dark btn-circle me-4 fw-semibold prev">
                    <img src="/website-assets/prev.png" alt="Previous" height="23px" class="navigation-img">
                </button>
                <button class="btn border-dark btn-circle me-4 fw-semibold next">
                    <img src="/website-assets/next.png" alt="Next" height="23px" class="navigation-img">
                </button>
            </div>
        </div>

        {{-- Offer Section --}}
        <div class="row d-flex justify-content-center align-items-center my-5">
            <h2 class='text-center my-md-5 my-3'>Special Offer</h2>

            <div class="col-md-6 px-4 py-4">
                <img src="/website-assets/offer-1.png" alt="Hyundai Palisade" class="w-100 img-fluid">
            </div>

            <div class="col-md-6 px-4" data-aos="fade-left" data-aos-once='true' data-aos-duration="500" data-aos-anchor-placement='top-bottom'>
                <h3 class="fw-bold text-uppercase">Porsche 911 Carrera</h3>
                <h5 class="mb-3">Only for <span class='text-primary'>Rp 5 mio / day</span></h5>

                <p><span><img src="/website-assets/tick.png" alt="" width="20px"></span> 380 Horsepower</p>
                <p><span><img src="/website-assets/tick.png" alt="" width="20px"></span> 293 km/h top speed</p>
                <p><span><img src="/website-assets/tick.png" alt="" width="20px"></span> 0 - 100 in 4.2s</p>

                <a href="{{ route('rent-schedule') }}"><button class="btn btn-primary mt-4 px-5 py-2">Rent Now!</button></a>
            </div>
        </div>

        {{-- Contact Section --}}
        <div class="row d-flex justify-content-center my-5 px-4">
            <div class="col-md-6 my-4 contact-us-img">
                <h2 class='my-lg-3 text-center text-md-start'>Reach out to us</h2>
                <p class=" text-center text-md-start text-muted">We’d love to hear your feedback and suggestions</p>

                <div class="row mt-4 d-flex justify-content-md-start justify-content-center">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="" class="btn btn-circle btn-dark d-flex align-items-center"><img src="/website-assets/Whatsapp.png" alt="phone" width="20px"></a>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="" class="btn btn-circle btn-dark d-flex align-items-center"><img src="/website-assets/email.png" alt="email" width="20px"></a>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="" class="btn btn-circle btn-dark d-flex align-items-center"><img src="/website-assets/instagram.png" alt="Instagram" width="20px"></a>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <a href="" class="btn btn-circle btn-dark d-flex align-items-center"><img src="/website-assets/twitter.png" alt="Twitter" width="20px"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 tile p-4">
                <form action="/reachout" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-4 mt-2">
                                <input type="text" class="form-control py-2 @error('first_name') is-invalid @enderror" id="first_name" name='first_name' placeholder="First Name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-4 mt-2">
                                <input type="text" class="form-control py-2 @error('last_name') is-invalid @enderror" id="last_name" name='last_name' placeholder="Last Name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control py-2 @error('email') is-invalid @enderror" id="email" name='email' placeholder="Email address" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <textarea class="form-control @error('email') is-invalid @enderror" placeholder="Type your message here" id="message" name='message' style="height: 165px; resize:none" value="{{ old('message') }}" required></textarea>
                        @error('message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button class="btn btn-outline-primary w-100 mt-5 py-2">Send</button>
                </form>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="d-flex justify-content-center align-items-center mt-5 px-3 footer">
        <div class="container">
            <div class="row ">
                <div class="col-md-4 py-3 d-flex flex-column justify-content-center align-items-center align-items-md-start order-2 order-md-1">
                    <h3 class='fw-bold'>Rentcars<span class="text-primary">.id</span></h3>
                    <p class="fw-bold text-muted mb-0">&#169 2023 All Rights Reserved</p>
                </div>

                <div class="col-md-8 d-flex flex-row justify-content-md-end justify-content-center align-items-center mt-3 mb-md-0 order-1 order-md-2">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }} me-5" href="/">HOME</a>
                        <a class="nav-link {{ Request::is('about/*') ? 'active' : '' }} me-5" href="/about">ABOUT</a>
                        <a class="nav-link {{ Request::is('rent/*') ? 'active' : '' }}" href="/rent/schedule">RENT</a>
                </div>
            </div>
        </div>
    </footer>  

    {{-- Toasts --}}
    @if (session()->has('ticket-submission-success') && session()->get('ticket-submission-success'))
        <div class="toast position-fixed text-bg-dark bottom-25 start-50 translate-middle-x py-2" id='successToast' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-success fw-semibold">
                Your message has been sent!
            </div>
        </div>
        <button class="btn visually-hidden" id="showToast" onclick='showToast(true)'></button>
        <?php session()->forget('ticket-submission-success') ?>

    @elseif (session()->has('ticket-submission-success') && !session()->get('ticket-submission-success'))
        <div class="toast position-fixed text-bg-dark bottom-25 start-50 translate-middle-x py-2" id='failedToast' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                Failed to send message, please try again!
            </div>
        </div>
        <button class="btn visually-hidden" id="showToast" onclick='showToast(false)'></button>
        <?php session()->forget('ticket-submission-success') ?>
    @endif

    <script src='js/home.js'></script>
@endsection
