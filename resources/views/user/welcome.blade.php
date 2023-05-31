@extends('user.layouts.main')

<style>
    .landing {
        height: 100vh !important;
    }

    .landing-img {
        width: 100%;
    }

    .why-us-card > div {
        min-height: 60vh !important;
    }
    
    .why-us-icon {
        width: 100px;
        aspect-ratio : 1/1;
        border-radius: 50%;
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

    .input-group {
        border-radius: .375rem !important;
        border: none !important;
    }

    .input-group i {
        position: absolute;
        margin-top: 12px;
        margin-left: 0.75rem;
        z-index: 5000;
    }

    .input-group .form-control {
        padding-left: 2.5rem !important;
        border-radius: .375rem !important; 
    }

    .cars::-webkit-scrollbar {
        height: 7px;
    }

    .toast {
        bottom: 20px;
        z-index: 5001;
    }

    .footer {
        background-color: var(--primary-300)
    }

    @media screen and (max-width:992px) {
        .landing {
            height: 75vh !important;
        }

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
        .landing-img-container, .contact-us-img {
            display: none;
        }

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
</style>

@section('container')
    <div class="container">
        @if(session()->has('success'))
            <p>Tes</p>
        @endif

        @d(auth()->user())

        {{-- Landing --}}
        <div class="row d-flex justify-content-center align-items-center px-3 landing">
            <div class="col-md-6" style="margin-top:-40px" data-aos="fade-right" data-aos-once='true' data-aos-duration="1000" data-aos-anchor-placement='top-center'>
                <h1 class='fw-bold mb-3'>Drive Your Way</h1>
                <p class='fs-5 mb-3'>Rent any car with <br>affordable prices anywhere in Indonesia</p>
                <a href="/rent" class="btn btn-primary px-5 py-2 fw-semibold mb-3">Get Started</a>
            </div>

            <div class="col-md-6 landing-img-container" data-aos="fade-left" data-aos-once='true' data-aos-duration="1000" data-aos-anchor-placement='top-center'>
                <img src="storage/website-assets/landing-bg.png" alt="Landing Background" class="landing-img">
            </div>
        </div>
    
        {{-- Why Us Section --}}
        <div class="row d-flex justify-content-center align-items-center why-us my-5">
                <div class="col-12 mb-5">
                    <h1 class='fw-bold text-center m-0 p-0'>Why <span class="text-primary">Us</span></h1>
                </div>
    
                <div class="col-md-4 px-4 why-us-card" data-aos="zoom-in" data-aos-once='true' data-aos-duration="750" data-aos-anchor-placement='top-center'>
                    <div class="p-4 tile mb-0">
                        <div class='why-us-icon d-flex justify-content-center align-items-center mb-5' style="background-color:#d6338425">
                            <img src="storage/website-assets/award.png" alt="Top Quality Cars" width="60px">
                        </div>
    
                        <h5 class="fw-semibold">Top Car Quality</h5>
                        <p>We care for our car as much as we care about you</p>
                    </div>
                </div>
    
                <div class="col-md-4 px-4 why-us-card" data-aos="zoom-in" data-aos-once='true' data-aos-duration="750" data-aos-anchor-placement='top-center'>
                    <div class="p-4 tile mb-0">
                        <div class='why-us-icon d-flex justify-content-center align-items-center mb-5' style="background-color:#0d6efd25">
                            <img src="storage/website-assets/support.png" alt="24/7" width="60px">
                        </div>
    
                        <h5 class="fw-semibold">24 / 7 Customer Support</h5>
                        <p>Our customer support is always ready to help you throughout your journey</p>
                    </div>
                </div>
    
                <div class="col-md-4 px-4 why-us-card" data-aos="zoom-in" data-aos-once='true' data-aos-duration="750" data-aos-anchor-placement='top-center'>
                    <div class="p-4 tile mb-0">
                        <div class='why-us-icon d-flex justify-content-center align-items-center mb-5' style="background-color:#20c99725">
                            <img src="storage/website-assets/price-tag.png" alt="Top Quality Cars" width="60px">
                        </div>
    
                        <h5 class="fw-semibold">Affordable Price</h5>
                        <p>Get the best price for your journey</p>
                    </div>
                </div>
        </div>

        {{-- Offer Section --}}
        <div class="row d-flex justify-content-center align-items-center my-5 px-3">
            <h1 class='fw-bold text-center my-md-5'>Special Offer</h1>

            <div class="col-md-6 col-lg-4 order-2 order-md-1 mt-5" data-aos="fade-right" data-aos-once='true' data-aos-duration="500" data-aos-anchor-placement='top-bottom'>
                <h3>Hyundai Palisade</h3>
                <h5 class="text-primary fw-semibold mb-3">Only Rp 600.000/day</span></h5>

                <p><span><img src="/storage/website-assets/checked.png" alt="" width="20px"></span> Up to 7 passengers</p>
                <p><span><img src="/storage/website-assets/checked.png" alt="" width="20px"></span> Incredible Sound System</p>
                <p><span><img src="/storage/website-assets/checked.png" alt="" width="20px"></span> Tinted windows for extra privacy</p>
                <p><span><img src="/storage/website-assets/checked.png" alt="" width="20px"></span> Large baggage up to 4 bags</p>

                <a href=""><button class="btn btn-primary fw-semibold px-5 py-2">Rent Now!</button></a>
            </div>

            <div class="col-md-6 order-1 order-md-2 my-5">
                <img src="/storage/vehicle-image/Palisade.png" alt="Hyundai Palisade" class="w-100 img-fluid">
            </div>
        </div>

        {{-- Fleet Section --}}
        <div class="row d-flex justify-content-center align-items-center my-5 px-3">
            <h1 class='fw-bold text-center mt-5'>Our Fleet</h1>
            <p class="text-muted text-center">We offer all kinds of cars including luxury, SUV, and minibus</p>

            <div class="col-md-6 d-flex justify-content-center">
                <form method="POST" class="w-100">
                    @csrf
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-2 col-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="all" autocomplete="off" value='all' checked>
                            <label class="btn m-0 w-100 fw-semibold" for="all">
                                All
                            </label>
                        </div>

                        <div class="col-lg-2 col-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="luxury" autocomplete="off" value='Luxury' checked>
                            <label class="btn btn-primary m-0 w-100 fw-semibold" for="luxury">
                                Luxury
                            </label>
                        </div>

                        <div class="col-lg-2 col-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="family" autocomplete="off" value='Family'>
                            <label class="btn m-0 w-100 fw-semibold" for="family">
                                Family
                            </label>
                        </div>

                        <div class="col-lg-2 col-3 px-1">
                            <input type="radio" class="btn-check fleetFilter" name="vehicle_type" id="minibus" autocomplete="off" value='Minibus'>
                            <label class="btn m-0 w-100 fw-semibold" for="minibus">
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
                            <figure class="figure bg-secondary p-4 rounded d-flex justify-content-center align-items-center">
                                <img src="{{ $car->vehicle_image }}" class="figure-img img-fluid rounded d-flex justify-content-center align-items-center" alt="...">
                            </figure>
                            <p class="fw-semibold mt-1 mb-0">{{ $car->brand . ' ' . $car->model }}</p>
                            <span class="badge text-dark d-flex align-items-center justify-content-start">
                                <img src="/storage/website-assets/group.png" alt="" height="25px">
                                <span class="ps-2 fs-6">{{ ' ' . $car->capacity}}</span>
                                <img src="/storage/website-assets/baggage.png" alt="" height="25px" class="ps-3">
                                <span class="ps-2 fs-6">{{ ' ' . $car->trunk }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-center mt-md-3">
                <button class="btn btn-secondary btn-circle me-3 fw-semibold prev">
                    <img src="/storage/website-assets/prev.png" alt="Previous" height="20px">
                </button>
                <button class="btn btn-primary btn-circle me-3 fw-semibold next">
                    <img src="/storage/website-assets/next.png" alt="Next" height="20px">
                </button>
            </div>
        </div>

        {{-- Contact Section --}}
        <div class="row d-flex justify-content-center align-items-center my-5 px-3">
            <h1 class='fw-bold text-center my-lg-3'>Reach out to us</h1>
            <p class="text-muted text-center">We'll reach back via email address that you provided</p>

            <div class="col-md-6 contact-us-img">
                <img src="/storage/website-assets/contact-us-2.png" alt="Contact Us!" class="w-100 img-fluid">
            </div>

            <div class="col-md-6 tile p-4">
                <form action="/reachout" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-4 mt-2">
                                <i class="position-absolute"><img src="/storage/website-assets/user.png" alt="" height="17.5px"></i>
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
                                <i class="position-absolute"><img src="/storage/website-assets/user.png" alt="" height="17.5px"></i>
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
                        <div class="input-group mb-4">
                            <i class="position-absolute"><img src="/storage/website-assets/email.png" alt="" height="17.5px"></i>
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

                    <button class="btn btn-primary w-100 mt-3 py-2 fw-bold">Send</button>
                </form>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="d-flex justify-content-center align-items-center mt-5 px-3 footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 py-md-5 py-3 order-md-1 order-2">
                    <h3 class='fw-bold mb-3'>Rentcars<span class="text-primary">.id</span></h3>
                    <a href="https://www.instagram.com" target="_blank" class='me-2'><img src="/storage/website-assets/logo-ig.png" alt="" width="30px"></a>
                    <a href="https://www.twitter.com" target="_blank" class='me-2'><img src="/storage/website-assets/logo-twitter.png" alt="" width="30px"></a>
                    <a href="https://www.facebook.com" target="_blank" class=''><img src="/storage/website-assets/logo-fb.png" alt="" width="30px"></a>
                    <p class="mt-3">&#169 2023 All Rights Reserved</p>
                </div>
        
                <div class="col-md-8 py-md-5 py-3 order-md-2 order-1">
                    <h5 class="fw-semibold mb-3">Find Us In</h5>
                    <div class="row">
                        <div class="col-6 d-flex flex-column">
                            @for ($i = 0; $i < ceil($locations->count() / 2); $i++)
                                <a href="https://www.google.com/maps" class="text-decoration-none fw-semibold mb-1">{{ $locations[$i]->location_name }}</a>
                            @endfor
                        </div>
                        <div class="col-6 d-flex flex-column">
                            @for ($i = ceil($locations->count() / 2); $i < $locations->count(); $i++)
                                <a href="https://www.google.com/maps" class="text-decoration-none fw-semibold mb-1">{{ $locations[$i]->location_name }}</a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    {{-- Toasts --}}
    @if (session()->has('ticket-submission-success') && session()->get('ticket-submission-success'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='successToast' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-success fw-semibold">
                Your message has been sent!
            </div>
        </div>
        <button class="btn visually-hidden" id="showToast" onclick='showToast(true)'></button>
        <?php session()->forget('ticket-submission-success') ?>

    @elseif (session()->has('ticket-submission-success') && !session()->get('ticket-submission-success'))
        <div class="toast position-fixed text-bg-light bottom-25 start-50 translate-middle-x py-2" id='failedToast' role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-center text-danger fw-semibold">
                Failed to send message, please try again!
            </div>
        </div>
        <button class="btn visually-hidden" id="showToast" onclick='showToast(false)'></button>
        <?php session()->forget('ticket-submission-success') ?>
    @endif

    <script src='js/home.js'></script>
@endsection
