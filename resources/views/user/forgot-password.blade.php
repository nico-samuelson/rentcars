@extends('user.layouts.main')

@section('container')
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center w-100 vh-100">
            <div class="col-md-6">
                <form action="/forgot-password" method="POST">
                    @csrf
                    <h3 class="text-center mb-5 fw-bold">Reset Password</h3>

                    @if(session()->has('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @error('email')
                        <div class="alert alert-danger">
                        {{ $message }}
                        </div>
                    @enderror

                    <label for="email" class="form-label fw-semibold">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value='{{ old('email') }}' required autofocus>

                    <button class="btn btn-primary py-2 w-100 mt-5 fw-semibold">Get Password Reset Link</button>
                </form>
            </div>
        </div>
    </div>
@endsection