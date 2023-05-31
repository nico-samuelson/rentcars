@extends('user.layouts.main')

@section('container')
    <div class="container py-4">
        @include('user.partials.form-step')
            {{-- @dd($rent) --}}
        <div class="row mx-0 py-3">

            <div class="col-md-6 my-md-4 ps-md-0">
                <form action="/payment/store/{{ $rent->rent_number }}" method="POST" enctype="multipart/form-data" class="col p-4 tile border">
                    @csrf
                    <div class="row">
                        <h6 class="fw-semibold">Payment Detail</h6>
                        <div class="col-12 mb-3">
                            <label for="card_number" class="form-label mb-2">Card Number</label>
                            <input type="text" class="form-control @error('card_number') is-invalid @enderror" id="card_number" name='card_number' value="{{ old('card_number') }}">

                            @error('card_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="expiration_month" class="form-label mb-2">Expiration Month</label>
                            <input type="text" class="form-control @error('expiration_month') is-invalid @enderror" id="expiration_month" name='expiration_month' value="{{ old('expiration_month') }}">

                            @error('expiration_month')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="expiration_year" class="form-label mb-2">Expiration Year</label>
                            <input type="text" class="form-control @error('expiration_year') is-invalid @enderror" id="expiration_year" name='expiration_year' value="{{ old('expiration_year') }}">

                            @error('expiration_year')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="cvc" class="form-label mb-2">CVC</label>
                            <input type="number" class="form-control @error('cvc') is-invalid @enderror" id="cvc" name='cvc' value="{{ old('cvc') }}">

                            @error('cvc')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        
                    </div>
                
            </div>

            <div class="col-md-6 my-md-4 pe-md-0">
                {{-- Payment Summary --}}
                <div class="col p-4 tile border">
                    <h5 class="fw-semibold">
                        {{ $rent->vehicle->vehicleModel->brand . ' ' . $rent->vehicle->vehicleModel->model }}
                    </h5>

                    <hr>

                    <div class="hstack mt-3">
                        <div class='w-50'>Daily Rate</div>
                        <div class="w-50 text-end fw-semibold">
                            Rp {{ number_format($rent->total_price / date_diff(new Datetime($rent->end_date), new Datetime($rent->start_date))->d, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="hstack mt-3">
                        <div class='w-50'>Duration</div>
                        <div class="w-50 text-end fw-semibold">
                            {{ 
                                date_diff(new Datetime($rent->end_date), new Datetime($rent->start_date))->d == 1 ?
                                date_diff(new Datetime($rent->end_date), new Datetime($rent->start_date))->d . ' day' :
                                date_diff(new Datetime($rent->end_date), new Datetime($rent->start_date))->d . ' days'
                            }} 
                        </div>
                    </div>

                    <hr class="mb-0">
                    <div class="hstack fw-semibold py-3 mb-3">
                        <div class='w-50'>Total</div>
                        <div class="w-50 text-end fs-4">
                            Rp {{ number_format($rent->total_price, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- Promo Button --}}
                    <button class="btn bg-primary-300 w-100 py-2 mb-3 fw-semibold" type="button">Use Promo</button>

                    <button class="btn btn-primary w-100 py-2 fw-semibold" type="submit">Pay</button>

                    <div class="hstack text-muted pb-4 mt-3">
                        <small class="text-muted w-100">
                            Please complete your payment before <span class="text-primary fw-semibold">{{ date('d/m/Y', strtotime(date($rent->created_at). ' + 2 days'))  }} at 23:59 WIB</span>, otherwise your order will be automatically cancelled
                        </small>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection