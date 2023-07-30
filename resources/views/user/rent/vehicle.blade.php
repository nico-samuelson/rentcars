@extends('user.layouts.main')

@section('style')
    <style>
        html {
            overflow-x:hidden !important;
        }

        .transmissions .btn {
            color: #aaa !important;
            border: 2px solid #88888850;
        }

        .fixed-tile {
            position: fixed;
        }
    </style>
@endsection

@section('container')
    <div class="container py-4 justfiy-content-center">
        @include('user.partials.form-step')

        @if(session()->has('error'))
            <div class="alert alert-danger my-4">
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="row mx-1 my-4">
            {{-- Left Panel --}}
            <div class="col-lg-6 pe-lg-5 pb-4 h-100" id="fixed-pos">
                <div class="row p-lg-5 p-3 tile">
                    <div class="col-lg-2 py-4">
                        <a href='/rent/vehicles'><i class="fa-solid fa-arrow-left fa-2xl"></i></a>
                    </div>
                    <div class="col-lg-10">
                        <h3>{{ $car->brand . ' ' . $car->model }}</h3>
                        <h6 class="text-primary mt-3 fw-bold fs-4">Rp {{ number_format($car->daily_rate, 0, ',', '.') }}/day</h6>
        
                        <img src="{{ $car->vehicle_image }}" alt="{{ $car->model }}" class="img-fluid mt-lg-4">
                    </div>
                </div>
            </div>

            {{-- Right Panel --}}
            <form action="/rent/set-vehicle/{{ $car->model }}" method="POST" id="cekmobil" class="col-lg-6 p-md-5 p-4 tile">
                @csrf
                {{-- Check Availability --}}
                <div class="row">
                    <div class="col-6 mb-4">
                        <label for='start_date' class="mb-2">Pick Up</label>
                        <input type="datetime-local" class="form-control" id="start_date" name='start_date' value="{{ session()->get('rent_data')['start_date'] ?? old('start_date') }}">

                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-4">
                        <label for='end_date' class="mb-2">Return</label>
                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name='end_date' value="{{ session()->get('rent_data')['end_date'] ?? old('end_date') }}">

                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col">
                        <div class="status mb-4">
                        </div>
                    </div>
                </div>

                {{-- Transmissions --}}
                <p class="fs-5 mb-4">Select Transmission</p>
                <div class="row mb-4">
                    @foreach($transmissions as $t)
                        <div class="col-6 transmissions">
                            <input class="btn-check w-100 toggleTransmission" type="radio" name="transmission" id="{{ $t->transmission }}" value="{{ $t->transmission }} "{{  $loop->first ? 'checked' : ''}}>

                            <label class="btn w-100 py-2" for="{{ $t->transmission }}">
                                {{ ucwords($t->transmission) }}
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- Specifications --}}
                <p class="fs-5 mb-4">Specifications</p>
                <div class="text-muted mb-4">
                    <div class="hstack mt-3">
                        <div class='w-75'>Passengers</div>
                        <div class='w-25 text-end'>{{ $car->capacity }}</div>
                    </div>
                    <div class="hstack mt-3">
                        <div class='w-75'>Baggage capacity</div>
                        <div class='w-25 text-end'>{{ $car->trunk }}</div>
                    </div>
                    <div class="hstack mt-3">
                        <div class='w-75'>Power</div>
                        <div class='w-25 text-end'>{{ $car->HP }} hp</div>
                    </div>
                    <div class="hstack mt-3">
                        <div class='w-75'>Torque</div>
                        <div class='w-25 text-end'>{{ $car->torque }} Nm</div>
                    </div>
                    <div class="hstack mt-3">
                        <div class='w-75'>Top speed</div>
                        <div class='w-25 text-end'>{{ $car->top_speed }} km/h</div>
                    </div>
                    <div class="hstack mt-3">
                        <div class='w-75'>0-100 km/h</div>
                        <div class='w-25 text-end'>{{ $car->acceleration }} s</div>
                    </div>
                </div>

                {{-- Facilities --}}
                <p class="fs-5 mb-4">Facilities</p>
                <ul class="text-muted mt-0">
                    <li class="my-3">Air Conditioner</li>
                    <li class="my-3">Bluetooth Audio</li>
                    <li class="my-3">Blablabla</li>
                </ul>

                <button class="btn btn-primary w-100">Choose Vehicle</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
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
                            // console.log('error')
                            $.each(response.error, function(i) {
                                $("#" + i).addClass("is-invalid");
                                $("#" + i).parent().append('<div class="invalid-feedback errors">' + response.error[i] + `</div>`)
                            })
                        }

                        else if (response.length > 0) {
                            // console.log("onok")
                            $(".status").html('<div class="alert alert-success fw-semibold">Car is available!</div>')
                        }
                        
                        else {
                            // console.log('ga onok')
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
            $("input[name='transmission']:checked").next().css('color', '#fff');
            $("input[name='transmission']:checked").next().css("border", 'none');

            $(document.body).on("change", ".toggleTransmission", function() {
                const id = $(this).val()

                $('input[name="transmission"]').next().removeClass('bg-primary');
                $('input[name="transmission"]').next().css('color', '#aaa');
                $("input[name='transmission']:checked").css("border", 'none');

                if ($(this).is(':checked')) {
                    $(this).next().addClass('bg-primary');
                    $(this).next().css('color', '#fff');
                    $(this).next().css("border", 'none');
                }
            })

            // sticky panel
            let fixed = false;
            const navbar = document.getElementById("navbar")
            const step = document.getElementById('form-step')

            $(window).scroll(function(e) {
                if ((document.getElementById('fixed-pos').getBoundingClientRect().top - navbar.offsetHeight) <= 0 && !fixed && window.innerWidth > 992) {
                    fixed = true;
                    console.log('tes')
                    $("#fixed-pos").addClass('fixed-tile')
                    $("#fixed-pos").css("top", (navbar.offsetHeight + 10) + 'px')
                    $("#fixed-pos").css("width", ($("#fixed-pos").parent().width() / 2) + 'px')
                    $("#fixed-pos").after('<div class="col-lg-6"></div>')
                }
                else if ($(window).scrollTop() < (navbar.offsetHeight + step.offsetHeight + 10) && fixed){
                    fixed = false;
                    $("#fixed-pos").removeClass('fixed-tile')
                    $("#fixed-pos").next().remove()
                }
            })
        })
    </script>
@endsection