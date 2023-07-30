@foreach($rents as $rent)
    <div class="tile p-5 mb-4">
        <div class="row d-flex align-items-center">
            <div class="col fw-semibold fs-4 p-0">
                {{ $rent->rent_number }}
            </div>

            <div class="col d-flex justify-content-end p-0">
                @if ($rent->status_id == 1 || ($rent->status_id <= 7 && $rent->status_id >= 5))
                    <span class="badge rounded-pill text-bg-danger px-3 p-2">{{ $rent->rentStatus->status }}</span>
                @else
                    <span class="badge rounded-pill text-bg-success px-3 py-2">{{ $rent->rentStatus->status }}</span>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-3 col-8 p-0">
                <img src="{{ $rent->vehicle->vehicleModel->vehicle_image }}" alt="" class="img-fluid">
            </div>  

            <div class="col-md-6 p-0 p-lg-2">
                <p class="mb-0">
                    <span class="fw-semibold mb-1">
                        {{ $rent->vehicle->vehicleModel->brand . ' ' . $rent->vehicle->vehicleModel->model }}
                    </span>

                    <br>
                    {{ date_format(new Datetime($rent->start_date), 'd/m/Y') . ' - ' . date_format(new Datetime($rent->end_date), 'd/m/Y') }}
                </p>
            </div>

            <div class="col-md-3 mt-3 mt-md-0 text-md-end p-0 pe-1">
                Total
                <br>
                <span class="fw-semibold">Rp {{ number_format($rent->total_price, 0 , ',', '.') }}</span>
            </div>

            <div class="col-12 d-flex justify-content-start justify-content-md-end align-items-center p-0 mt-4 mt-lg-0">
                <div class="hstack gap-3">
                    @if ($rent->status_id == 1 ||
                        ($rent->status_id <=3 && date_diff(new Datetime($rent->start_date), now())->d >= 1))
                        <form method="POST" action="/rent/cancel/{{ $rent->id }}" id='cancel' class='p-0 m-0'>
                            @csrf
                            <button class="btn btn-warning px-4 py-2" type='button' id='cancelBooking'>Cancel</button>
                        </form>
                    @endif

                    @if ($rent->status_id != 1)
                        <a href="/user/booking/{{ $rent->rent_number }}"><button class="btn btn-primary px-4 py-2">Show Detail</button></a>
                    @endif

                    @if($rent->status_id == 1)
                        <a href="/payment/create/{{ $rent->rent_number }}"><button class="btn btn-primary px-5 py-2">Pay</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach