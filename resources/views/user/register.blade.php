<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        {{-- Bootstrap Icons --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- Custom Style --}}
        <link rel='stylesheet' href='/css/style.css'>

        <style>
            body {
                background-color:#fff !important;
            }

            .pc-register {
                background-color: #c4c4e9 !important;
            }

            .register-form {
                width: 60% !important;
            }

            .social-text {
                display: flex;
                align-items: center;
                text-align: center;
            }

            .social-text::before,
            .social-text::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid #bbb;
            }

            .social-text:not(:empty)::before {
                margin-right: 1em;
            }

            .social-text:not(:empty)::after {
                margin-left: 1em;
            }

            @media screen and (max-width:768px) {
                .pc-register {
                    display: none !important;
                }
                .register-form {
                    width: 100% !important;
                }
                .register-header {
                    text-align: center !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="container-fluid p-0 m-0">
            <div class="row w-100 vh-100 p-0 m-0">
                <div class="col-md-6 pc-register d-flex justify-content-center align-items-center position-fixed vh-100">
                    <img src="/storage/website-assets/login-illustration.png" alt="Car Rent Illustration" width="450px">
                </div>

                <div class="col-md-6"></div>

                <div class="col-md-6 d-flex justify-content-center align-items-center p-5">
                    <form action="/register" method="POST" class="register-form">
                        @csrf
                        <div class="register-header">
                            <h2 class="fw-bold d-block">Let's Get Started!</h2>
                            <p class="text-muted mb-md-5">Create your account to start renting</p>
                        </div>
                        
                        {{-- Register Form --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="birth_date" class="form-label fw-semibold">Birth Date</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>

                            @error('birth_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>  

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="password_confirm" class="form-label fw-semibold">Retype Password</label>
                            <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" id="password_confirm" name="password_confirm" required>

                            @error('password_confirm')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Sign Up Button --}}
                        <button class="btn btn-primary fw-semibold w-100 py-2 mb-4">Sign Up</button>

                        {{-- Social Sign Up --}}
                        <div class="mb-4 social-text">
                            Or Sign Up With
                        </div>

                        <div class="hstack gap-3 mb-4">
                            <div class="w-50 position-relative">
                                <a href="">
                                    <button class="btn border w-100 py-2 fw-semibold">
                                        <img src="/storage/website-assets/google.png" height="20px" class="py-0 pe-2">Google
                                    </button>
                                </a>
                            </div>
                            <div class="w-50">
                                <a href="">
                                    <button class="btn border w-100 py-2 fw-semibold">
                                        <img src="/storage/website-assets/facebook.png" height="20px" class="py-0 pe-2">Facebook
                                    </button>
                                </a>
                            </div>
                        </div>

                        {{-- Redirect to sign up page --}}
                        <p class="text-center text-muted">Already have an account? <a href="/login" class="text-decoration-none">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>