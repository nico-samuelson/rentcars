@extends('user.layouts.main')

<style>
    .header {
        border-radius: 15pt !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        height: 150px;
    }

    .profile-picture {
        display: block !important;
        width: 100px !important;
        aspect-ratio : 1/1 !important;
        border-radius: 50%;
        padding: 0 !important;
        margin: 100px auto !important;
    }

    .toast {
        bottom: 20px;
        z-index: 5001;
    }

    #hidePass, #showPass {
        right: 15px;
        top: 35px;
    }

    #hidePass {
        display: none;
    }

    input:checked + label {
        background-color: var(--primary) !important;
        color: #fff !important;
        border: none !important;
    }

    label {
        cursor: pointer;
        border: 1px solid #bbb !important;
    }

    .swal2-actions button {
        width: 7.5em;
        padding: .5em 1.5em !important;
        margin-right: .5em !important;
    }

    label {
        border: 2px solid #88888850 !important;
    }

    .status-filter {
        white-space: nowrap;
        overflow-x: auto;
    }
</style>

@section('container')
    <div class="container p-4">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-6 d-flex justify-content-center mt-4">
                <form method="POST" class="w-100">
                    @csrf
                    <div class="hstack gap-3 flex-nowrap status-filter">
                        <div>
                            <input type="radio" class="btn-check booking-filter" name="status_id" id="Unpaid" autocomplete="off" value='Unpaid' checked>
                            <label class="text-muted fw-normal rounded-pill px-3 py-2 m-0 w-100" for="Unpaid">
                                Unpaid
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check booking-filter" name="status_id" id="Ongoing" autocomplete="off" value='Ongoing'>
                            <label class="text-muted fw-normal rounded-pill px-3 py-2 m-0 w-100" for="Ongoing">
                                On Progress
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check booking-filter" name="status_id" id="Rejected" autocomplete="off" value='Rejected'>
                            <label class="text-muted fw-normal rounded-pill px-3 py-2 m-0 w-100" for="Rejected">
                                Rejected
                            </label>
                        </div>
                        <div>
                            <input type="radio" class="btn-check booking-filter" name="status_id" id="Completed" autocomplete="off" value='Completed'>
                            <label class="text-muted fw-normal rounded-pill px-3 py-2 m-0 w-100" for="Completed">
                                Completed
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            
            {{-- User Booking History --}}
            <div class="col-lg-8">
                @if(session()->has('Success'))
                    <div class="alert alert-success">
                        {{ session('Success') }}
                    </div>
                @elseif(session()->has('Error'))
                    <div class="alert alert-danger">
                        {{ session('Error') }}
                    </div>
                @endif

                <div class="vstack gap-3 bookings mt-4">
                    @if ($rents->count())
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
                    @else
                        <h3 class="mt-3 text-center">No Data Found</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            $(document.body).on('change', '.booking-filter', function() {
                $.ajax({
                    url : '/user/filterBooking',
                    type : 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        bookingStatus : $(this).val(),
                    },
                    success : function(response) {
                        console.log(response)
                        $(".bookings").empty()
        
                        console.log(response)
                        if (response == '')
                            $(".bookings").html("<h3 class='mt-3 text-center'>No Data Found</h3>")
                        
                        else
                            $(".bookings").html(response)
                    }
                })
            })

            $(document.body).on('click', '#cancelBooking', function(e) {
                e.preventDefault();

                swalWithBootstrapButtons.fire({
                    title : "Are you sure?",
                    icon : "warning",
                    showCancelButton: true,
                }).then((result) => {
                    if(result.isConfirmed){
                        $("#cancel").submit();
                    }
                })
            })
        })
    </script>
@endsection