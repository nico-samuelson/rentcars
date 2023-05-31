@extends('user.layouts.main')

@section('container')
{{-- @dd($payment) --}}
    <div class="container py-4">
        <div class="row mx-0 py-3 d-flex justify-content-center align-items-center mt-4">
            <div class="col-md-6 tile border p-5">
                <img src="/storage/website-assets/check.png" alt="Successful Payment" height="150px" class="mx-auto d-block">
                <h4 class="text-center fw-semibold mt-4">Payment Success</h4>
                <h3 class="fw-semibold mt-4 text-center">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</h3>
                <hr>
                <div class="row">
                    <div class="hstack mb-3">
                        <div class="text-start w-50">Ref. Number</div>
                        <div class="text-end w-50 fw-semibold">{{ $payment->reference_number }}</div>
                    </div>
                    <div class="hstack mb-3">
                        <div class="text-start w-50">Rent Number</div>
                        <div class="text-end w-50 fw-semibold">{{ $payment->rent->rent_number }}</div>
                    </div>
                    <div class="hstack mb-3">
                        <div class="text-start w-50">Date</div>
                        <div class="text-end w-50 fw-semibold">{{ date_format(new Datetime($payment->created_at), 'd/m/Y') }}</div>
                    </div>
                    <div class="hstack mb-3">
                        <div class="text-start w-50">Time</div>
                        <div class="text-end w-50 fw-semibold">{{ date_format(new Datetime($payment->created_at), 'H:i:s') }}</div>
                    </div>

                    <a href="/user/booking"><button class="btn btn-primary mt-3 fw-semibold w-100">Show My Booking</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection