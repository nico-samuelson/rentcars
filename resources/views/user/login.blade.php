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
                margin: 0;
                padding: 0; 
            }

            .pc-login {
                background-color: #c4c4e9 !important;
                height: 100vh;
            }

            .login-form {
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

            @media screen and (max-width:991px) {
                .pc-login {
                    display: none !important;
                }
                .login-form {
                    width: 100% !important;
                }
                .login-header {
                    text-align: center !important;
                }
            }

            #hidePass, #showPass {
                right: 15px;
                top: 43px;
            }

            .social-text {
                color: #aaa !important;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid p-0 m-0">
            <div class="row p-0 m-0">
                <div class="col-lg-5 pc-login d-flex justify-content-center align-items-center p-5">
                    <img src="/storage/website-assets/login-illustration.png" alt="Car Rent Illustration" class="img-fluid p-5">
                </div>

                <div class="col-lg-7 d-flex justify-content-center align-items-center p-5 bg-dark">
                    <form action="/login" method="POST" class="login-form">
                        @csrf

                        <div class="login-header">
                            <h2 class="fw-bold text-primary">Welcome Back 👋</h2>
                            <p class="text-muted mb-lg-4">Please sign in to continue</p>
                        </div>
                        
                        @if(session()->has('loginError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('loginError') }}
                            </div>

                        @elseif(session()->has('accountDeleted'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('accountDeleted') }}
                            </div>

                        @elseif(session()->has('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('status') }}
                            </div>

                        @elseif(session()->has('passwordChanged'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('passwordChanged') }}
                            </div>

                        @elseif(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>

                        @endif

                        {{-- Login Form --}}
                        <div class="mb-4">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required>
                            <i class="fa-solid fa-eye position-absolute" id="showPass"></i>
                            <i class="fa-solid fa-eye-slash position-absolute" id="hidePass"></i>
                        </div>
                        
                        <div class="hstack mb-4">
                            <div class="form-check w-50">
                                <input class="form-check-input" type="checkbox" value="1" id="remember_me" name="remember_me">
                                <label class="form-check-label" for="remember_me">Remember Me</label>
                            </div>
                            <div class="w-50 text-end">
                                <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password</a>
                            </div>
                        </div>

                        {{-- Login Button --}}
                        <button class="btn btn-primary w-100 py-2 mb-4">Login</button>

                        {{-- Social Login --}}
                        <div class="mb-4 social-text">
                            Or
                        </div>
                        
                        <div class="mb-4">
                            <a href="">
                                <button class="btn border w-100 py-2" style="color:#aaa">
                                    <img src="/storage/website-assets/google.png" height="20px" class="py-0 pe-3">Sign in with Google
                                </button>
                            </a>
                        </div>

                        {{-- Redirect to sign up page --}}
                        <p class="text-center text-muted mb-0">Don't have an account? <a href="/register" class="text-decoration-none">Register here</a></p>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $("#hidePass").hide();

                $(document.body).on("click", '#showPass', function() {
                    $(this).parent().find('input').prop('type', 'text');
                    $(this).parent().find("#showPass").hide();
                    $(this).parent().find("#hidePass").show();
                })
                
                $(document.body).on("click", '#hidePass', function() {
                    $(this).parent().find('input').prop('type', 'password');
                    $(this).parent().find("#showPass").show();
                    $(this).parent().find("#hidePass").hide();
                })
            })
        </script>
    </body>
</html>