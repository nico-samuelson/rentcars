@extends('user.layouts.main')

<style>
    body {
        overflow: hidden;
    }

    .details {
        max-height: 80vh;
        overflow: auto;
    }

    /* width */
    .details::-webkit-scrollbar {
        width: 7px;
    }

    /* Track */
    .details::-webkit-scrollbar-track {
        border-radius: 20pt ;
    }

    /* Handle */
    .details::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 20pt;
    }

    /* Handle on hover */
    .details::-webkit-scrollbar-thumb:hover {
        background: #4933b9;
    }
</style>

@section('container')
    <div class="container py-4">
        <div class="row mt-5 p-3">
            <div class="col-md-3 py-4">
                <a href='{{ route("user.bookings") }}'><i class="fa-solid fa-arrow-left fa-2xl"></i></a>
            </div>

            <div class="col-md-6 tile p-md-5 p-4 details">

                {{-- Rent Detail --}}
                <h5 class="fw-semibold mb-3">Rent Detail</h5>
                <div class="row mb-2">
                    <div class="col text-muted">Rent Number</div>
                    <div class="col text-end fw-semibold text-primary">
                       {{ $rent->rent_number }}
                    </div>
                </div>

                <hr class="border-primary">
                <div class="row mb-2">
                    <div class="col text-muted">Location</div>
                    <div class="col text-end fw-semibold">
                        {{ $rent->location->location_name }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Pickup</div>
                    <div class="col text-end fw-semibold">
                        {{ date_format(new Datetime($rent->start_date), 'd-m-Y - H:i:s') }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Return</div>
                    <div class="col text-end fw-semibold">
                        {{ date_format(new Datetime($rent->end_date), 'd-m-Y - H:i:s') }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Renter Name</div>
                    <div class="col text-end fw-semibold">
                        {{ $rent->renter_name }}
                    </div>
                </div>

                {{-- Contact Person --}}
                <hr class="my-4 border-primary">
                <h5 class="fw-semibold mb-3">Contact Person</span></h5>
                <div class="row mb-2">
                    <div class="col text-muted">Name</div>
                    <div class="col text-end fw-semibold">
                        {{ $rent->admin->name }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Phone</div>
                    <div class="col text-end fw-semibold">
                        {{ $rent->admin->phone }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Email</div>
                    <div class="col text-end fw-semibold">
                        {{ $rent->admin->email }}
                    </div>
                </div>

                {{-- Vehicle Detail --}}
                <hr class="my-4 border-primary">
                <h5 class="fw-semibold mb-3">Vehicle Detail</span></h5>
                <div class="row mb-2">
                    <div class="col text-muted">Model</div>
                    <div class="col text-end fw-semibold">
                       {{ $rent->vehicle->vehicleModel->brand . ' ' . $rent->vehicle->vehicleModel->model }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">License Plate</div>
                    <div class="col text-end fw-semibold">
                       {{ $rent->vehicle->license_plate }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Year</div>
                    <div class="col text-end fw-semibold">
                       {{ $rent->vehicle->year }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Color</div>
                    <div class="col text-end fw-semibold">
                       {{ $rent->vehicle->color }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Transmission
                    </div>
                    <div class="col text-end fw-semibold">
                       {{ $rent->vehicle->transmission }}
                    </div>
                </div>

                {{-- Payment Detail --}}
                <hr class="my-4 border-primary">
                <h5 class="fw-semibold mb-3">Payment Detail</span></h5>
                <div class="row mb-2">
                    <div class="col text-muted">Ref. Number</div>
                    <div class="col text-end text-primary fw-semibold">
                        <a href="/payment/{{ $rent->payment->reference_number }}">{{ $rent->payment->reference_number }}</a>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Payment Method</div>
                    <div class="col text-end fw-semibold">
                        {{ $rent->payment->paymentMethod->method }}
                    </div>
                </div>
                <hr style="border:1px dashed var(--primary)">
                <div class="row mb-2">
                    <div class="col text-muted">Daily Rate</div>
                    <div class="col text-end text-muted">
                        Rp {{ number_format($rent->vehicle->vehicleModel->daily_rate, 0 , ',', '.') }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col text-muted">Duration</div>
                    <div class="col text-end text-muted">
                        {{ floor((strtotime($rent->end_date) - strtotime($rent->start_date)) / 86400) == 1 ?
                            floor((strtotime($rent->end_date) - strtotime($rent->start_date)) / 86400) . ' day' :
                            floor((strtotime($rent->end_date) - strtotime($rent->start_date)) / 86400) . ' days' }}
                    </div>
                </div>
                <hr style="border:1px dashed var(--primary)">
                <div class="row mb-2">
                    <div class="col fw-semibold">Total</div>
                    <div class="col text-end fw-semibold">
                        Rp {{ number_format($rent->total_price, 0 , ',', '.') }}
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
        })
    </script>
@endsection