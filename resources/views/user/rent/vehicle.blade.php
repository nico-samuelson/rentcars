@extends('user.layouts.main')

<style>
    .btn-check:checked {
        background: var(--primary) !important;
    }
</style>

@section('container')
    <div class="container py-4">
        @include('user.partials.form-step')
            
        {{-- Back button --}}
        <div class="col-12 my-md-5 my-4 p-0">
            <a href='/rent/vehicles'><i class="fa-solid fa-arrow-left fa-2xl"></i></a>
        </div>

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="row tile mx-1">
            <div class="col-lg-7 p-5 tile bg-secondary">
                <h3 class="fw-semibold">{{ $car->brand . ' ' . $car->model }}</h3>
                <h6 class="text-muted mt-3">Rp <span class="text-primary fw-bold fs-4">{{ number_format($car->daily_rate, 0, ',', '.') }}</span>/day</h6>

                <img src="{{ $car->vehicle_image }}" alt="{{ $car->model }}" class="w-100 img-fluid mt-4">
            </div>

            <form action="/rent/set-vehicle/{{ $car->model }}" method="POST" id="cekmobil" class="col-lg-5 py-4 px-1">
                @csrf
                {{-- <div class="col-lg-5 py-4 px-1"> --}}
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        {{-- Choose Transmission --}}
                        <div class="accordion-item py-3">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#transmission-accordion" aria-expanded="false" aria-controls="transmission-accordion">
                                Transmissions
                                </button>
                            </h2>
                            <div id="transmission-accordion" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    
                                        <div class="row">
                                            @foreach($transmissions as $t)
                                                <div class="col-6">
                                                    <input class="btn-check w-100 toggleTransmission" type="radio" name="transmission" id="{{ $t->transmission }}" value="{{ $t->transmission }} "{{  $loop->first ? 'checked' : ''}}>

                                                    <label class="btn border w-100 py-3" for="{{ $t->transmission }}">
                                                        {{ ucwords($t->transmission) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- Specs --}}
                        <div class="accordion-item py-3">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#spec-accordion" aria-expanded="false" aria-controls="spec-accordion">
                                Specifications
                                </button>
                            </h2>
                            <div id="spec-accordion" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="hstack mt-3 fw-semibold">
                                        <div class='w-75 ms-3'>Passengers</div>
                                        <div class='w-25 text-end me-3'>{{ $car->capacity }}</div>
                                    </div>
                                    <div class="hstack mt-3 fw-semibold">
                                        <div class='w-75 ms-3'>Baggage capacity</div>
                                        <div class='w-25 text-end me-3'>{{ $car->trunk }}</div>
                                    </div>
                                    <div class="hstack mt-3 fw-semibold">
                                        <div class='w-75 ms-3'>Power</div>
                                        <div class='w-25 text-end me-3'>{{ $car->HP }} hp</div>
                                    </div>
                                    <div class="hstack mt-3 fw-semibold">
                                        <div class='w-75 ms-3'>Torque</div>
                                        <div class='w-25 text-end me-3'>{{ $car->torque }} Nm</div>
                                    </div>
                                    <div class="hstack mt-3 fw-semibold">
                                        <div class='w-75 ms-3'>Top speed</div>
                                        <div class='w-25 text-end me-3'>{{ $car->top_speed }} km/h</div>
                                    </div>
                                    <div class="hstack mt-3 fw-semibold">
                                        <div class='w-75 ms-3'>0-100 km/h</div>
                                        <div class='w-25 text-end me-3'>{{ $car->acceleration }} s</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Facilities --}}
                        <div class="accordion-item py-3 border-bottom">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#facilitiy-accordion" aria-expanded="false" aria-controls="facilitiy-accordion">
                                Facilities
                                </button>
                            </h2>
                            <div id="facilitiy-accordion" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Check Availability --}}
                    <div class="row px-3 mt-4">
                            <div class="col-6 mb-3">
                                <label for='start_date' class="fw-semibold">Pick Up</label>
                                <input type="datetime-local" class="form-control" id="start_date" name='start_date' value="{{ session()->get('rent_data')['start_date'] ?? old('start_date') }}">

                                @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-6 mb-3">
                                <label for='end_date' class="fw-semibold">Return</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name='end_date' value="{{ session()->get('rent_data')['end_date'] ?? old('end_date') }}">

                                @error('end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col">
                                <div class="status">

                                </div>
                                <button class="btn btn-primary w-100">Next</button>
                            </div>
                        </div>
                    </div>
                {{-- </div> --}}
            </form>
        </div>
    </div>

<script>
    $(document).ready(function() {
        const paths = window.location.pathname.split('/')

        function checkVehicle() {
            const model = paths[paths.length - 1]
            const transmission = $("input[name='transmission']:checked").val();
            const start_date = $("#start_date").val();
            const start_time = $("#start_time").val();
            const end_date = $("#end_date").val();
            const end_time = $("#end_time").val();

            $.ajax({
                url : '/rent/check-vehicle/' + model,
                type : 'get',
                data : {
                    transmission : transmission, 
                    start_date : start_date,
                    start_time : start_time,
                    end_date : end_date,
                    end_time : end_time
                },
                success : function(response) {
                    // console.log(response)

                    $(".status").empty();
                    $(".errors").remove();
                    $(document.body).find(".is-invalid").removeClass('is-invalid');
                    
                    if (response != '' && response.error) {
                        console.log('error')
                        $.each(response.error, function(i) {
                            $("#" + i).addClass("is-invalid");
                            $("#" + i).parent().append('<div class="invalid-feedback errors">' + response.error[i] + `</div>`)
                        })
                    }

                    else if (response.length > 0) {
                        console.log("onok")
                        $(".status").html('<div class="alert alert-success fw-semibold">Car is available!</div>')
                    }
                    
                    else {
                        console.log('ga onok')
                        $(".status").html("<div class='alert alert-danger fw-semibold'>Car isn't available!</div>")
                    }
                }   
            })
        }

        checkVehicle()

        $(document.body).on("change", "#cekmobil input", function() {
            checkVehicle()
        })

        $("input[name='transmission']:checked").next().addClass('bg-primary');
        $("input[name='transmission']:checked").next().addClass('text-light');

        $(document.body).on("change", ".toggleTransmission", function() {
            const id = $(this).val()

            $('input[name="transmission"]').next().removeClass('bg-primary');
            $('input[name="transmission"]').next().removeClass('text-light');

            if ($(this).is(':checked')) {
                $(this).next().addClass('bg-primary');
                $(this).next().addClass('text-light');
            }
        })
    })
</script>
@endsection