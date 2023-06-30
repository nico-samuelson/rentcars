@extends('user.layouts.main')

<style>
    .btn-check:checked {
        background: var(--primary) !important;
    }
</style>

@section('container')
    <div class="container py-4">
        @include('user.partials.form-step')
            
        <div class="row p-3">
            {{-- Back button --}}
            <div class="col-md-3 my-md-5 my-4 ps-0 d-flex align-items-start">
                <a href='/rent/vehicles'><i class="fa-solid fa-arrow-left fa-2xl"></i></a>
            </div>

            <div class="col-md-6 my-4">
                <form action="/rent/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Summary --}}
                    <h4 class="text-primary fw-semibold mb-3">Summary</h4>
                    <div class="row tile border p-4 mb-5">
                        <h5 class="fw-semibold mb-3">
                            {{ $car->vehicleModel->brand . ' ' . $car->vehicleModel->model . ' - ' . ucwords($car->transmission)}}
                        </h5>

                        <hr>
                        
                        <p>
                        <span class="fw-semibold">Rent Location</span>
                            <br>
                            {{ $location->location_name }}
                        </p>

                        <p>
                            <span class="fw-semibold">Pickup Date & Time</span>
                            <br>
                            {{ date_format(new Datetime(session()->get('rent_data')['start_date']), 'D, j M Y - H:i:s') }}
                        </p>

                        <p>
                            <span class="fw-semibold">Return Date & Time</span>
                            <br>
                            {{ date_format(new Datetime(session()->get('rent_data')['end_date']), 'D, j M Y - H:i:s') }}
                        </p>
                    </div>

                    {{-- Rent Detail --}}
                    <h4 class="text-primary fw-semibold mb-3">Renter Detail</h4>
                    <div class="row tile border p-4 mb-5">
                        <div class="col-12 mb-3">
                            <label for="renter_name" class="form-label fw-semibold mb-2">Full Name</label>
                            <input type="text" class="form-control @error('renter_name') is-invalid @enderror" id="renter_name" name='renter_name' value="{{ old('renter_name') }}">
                            <span class="form-text">(without title)</span>

                            @error('renter_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="renter_phone" class="form-label fw-semibold mb-2">Phone Number</label>
                            <input type="tel" class="form-control @error('renter_phone') is-invalid @enderror" id="renter_phone" name='renter_phone' value="{{ old('renter_phone') }}">
                            <span class="form-text">include country code, ex: +62123456</span>

                            @error('renter_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="renter_email" class="form-label fw-semibold mb-2">Email</label>
                            <input type="email" class="form-control @error('renter_email') is-invalid @enderror" id="renter_email" name='renter_email' value="{{ old('renter_email') }}">

                            @error('renter_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Driver Detail --}}
                    <h4 class="text-primary fw-semibold mb-3">Driver Detail</h4>
                    <div class="row tile border p-md-4 p-3 mb-5">
                        <div class="col-12 mb-3">
                            <label for="driver_name" class="form-label fw-semibold mb-2">Full Name</label>
                            <input type="text" class="form-control @error('driver_name') is-invalid @enderror" id="driver_name" name='driver_name' value="{{ old('driver_name') }}">
                            <span class="form-text">(without title)</span>

                            @error('driver_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="driver_phone" class="form-label fw-semibold mb-2">Phone Number</label>
                            <input type="tel" class="form-control @error('driver_phone') is-invalid @enderror" id="driver_phone" name='driver_phone' value="{{ old('driver_phone') }}">
                            <span class="form-text">include country code, ex: +62123456</span>

                            @error('driver_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="driver_email" class="form-label fw-semibold mb-2">Email</label>
                            <input type="email" class="form-control @error('driver_email') is-invalid @enderror" id="driver_email" name='driver_email' value="{{ old('driver_email') }}">

                            @error('driver_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="driver_identity" class="form-label fw-semibold mb-2">National Identity / Passport</label>
                            <input type="file" class="form-control @error('driver_identity') is-invalid @enderror" id="driver_identity" name='driver_identity' value="{{ old('driver_identity') }}" accept="image/*">
                            <span class="form-text">only accepts .jpg, .png, or .jpeg file up to 2MB</span>

                            @error('driver_identity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label for="driver_license" class="form-label fw-semibold mb-2">Driving License</label>
                            <input type="file" class="form-control @error('driver_license') is-invalid @enderror" id="driver_license" name='driver_license' value="{{ old('driver_license') }}" accept="image/*">
                            <span class="form-text">only accepts .jpg, .png, or .jpeg file up to 2MB</span>

                            @error('driver_license')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <h4 class="text-primary fw-semibold mb-3">Terms and Conditions</h4>
                    <div class="row tile border p-md-4 p-3 mb-3">
                        <div class="form-check mb-3">
                            <input class="form-check-input @error('tnc-agreement') is-invalid @enderror" type="checkbox" value="yes" id="agreement1" name="tnc-agreement">
                            <label class="form-check-label" for="agreement1">
                            I have read and agreed to all the <a href="/terms-conditions">Terms & Conditions</a>
                            </label>

                            @error('tnc-agreement')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('privacy-policy-agreement') is-invalid @enderror" type="checkbox" value="yes" id="agreement" name="privacy-policy-agreement">
                            <label class="form-check-label" for="agreement">
                            I have read and agreed to Rentcars.id <a href="/privacy-policy">Privacy Policy</a>
                            </label>

                            @error('privacy-policy-agreement')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <button class="btn btn-primary w-100 mt-4 py-2 fw-semibold">Rent Car</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection