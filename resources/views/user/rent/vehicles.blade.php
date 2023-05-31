@extends('user.layouts.main')

<style>
    .car-img {
        -webkit-transform: scaleX(-1);
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        transform: scaleX(-1);
    }

    .highlight {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        /* height: 100%; */
    }

    .h-one {
        background-color: #d1d1e9 !important;
        height: 54% !important; 
    }

    .h-two {
        background-color: #99e6cf !important;
        height: 46% !important;
    }

    .h-three {
        background-color: #a5c3f6 !important;
        height: 46% !important;
    }

    .h-four {
        background-color: #fae799 !important;
        height: 54% !important;
    }

    small {
        font-size: 10px !important;
    }

    #sort {
        color: #fff;
        background-color: var(--primary);
    }

    .search-container {
        border-radius: .375rem !important;
        border: none !important;
        position: relative;
    }
    
    .search-container i {
        position: absolute;
        margin-top: 5px;
        right: 10px;
        z-index: 5000;
    }

    #searchbar {
        border: none !important;
        border-bottom : 2px solid var(--primary-300) !important;
        border-radius: 0;
    }

    #sort option {
        color: #000;
        background-color: #fff;
    }

    @media screen and (max-width:576px) {
        .most-popular-car {
            text-align: center;
        }
        .form-step-container {
            display: none;
        }
    }

    .top-shortcut {
        bottom: 20px;
        right: 20px;
    }
</style>

@section('container')
    <div class="container py-4">
        @include('user.partials.form-step')

        <div class="row mx-0 py-3">
            {{-- Back button --}}
            <div class="col-12 my-4 p-md-0 pt-4">
                <a href='/rent/schedule'><i class="fa-solid fa-arrow-left fa-2xl"></i></a>
            </div>
            
            {{-- Most Popular Model --}}
            {{-- <div class="row d-flex justify-content-center w-100 mb-3 ms-0">
                <h3 class="fw-semibold mb-3 text-center">Most Popular 🔥</h3>
                <div class="col-md-10 col-12 tile border">
                    @foreach($popular as $p)
                        <div class="row">
                            <div class="col-md-6 p-md-5 p-4 most-popular-car">
                                <h4 class="fw-semibold mb-3 ms-md-3">{{ $p->brand . ' ' . $p->model }}</h4>
                                <img src="{{ $p->vehicle_image }}" alt="{{ $p->vehicle_image }}" class="w-100 img-fluid car-img">
                                <h3 class="mt-3 ms-md-3 fw-semibold text-primary">
                                    Rp {{ number_format($p->daily_rate, 0, ',', '.') }}<span class="text-primary-300 fs-6">/day</span>
                                </h3>
                            </div>
    
                            <div class="col-md-3 col-6 vstack gap-2 d-flex flex-column align-items-center justify-content-center ps-4 pe-1 py-md-3 pb-3">
                                <div class="tile highlight h-one p-3">
                                    <img src="/storage/website-assets/power.png" alt="" height="60px">
                                    <h6 class="fw-semibold mt-3 mb-0">{{ $p->HP }} hp</h6>
                                </div>
                                <div class="tile highlight h-two p-3">
                                    <img src="/storage/website-assets/torque.png" alt="" height="60px">
                                    <h6 class="fw-semibold mt-3 mb-0">{{ $p->torque }} Nm</h6>
                                </div>
                            </div>
    
                            <div class="col-md-3 col-6 vstack gap-2 d-flex flex-column align-items-center justify-content-center ps-1 pe-4 py-md-3 pb-3">
                                <div class="tile highlight h-three p-3">    
                                    @if ($p->vehicle_type == 'Luxury') 
                                        <img src="/storage/website-assets/top_speed.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0">{{ $p->top_speed }} km/h</h6>
                                    @else
                                        <img src="/storage/website-assets/passengers.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0">{{ $p->capacity }} persons</h6>
                                    @endif
                                </div>
                                <div class="tile highlight h-four p-3">
                                    @if ($p->vehicle_type == 'Luxury')
                                        <img src="/storage/website-assets/acceleration.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0 text-center">{{ $p->acceleration }} s<br> (0-100km/h)</h6>
                                    @else
                                        <img src="/storage/website-assets/luggage.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0 text-center">{{ $p->trunk }} large bags</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}

            {{-- Filter --}}
            <div class="col-md-4 mt-md-4 ps-md-0">
                <div class="col p-4 tile border filter-container">
                <div class="row px-3">
                        <div class="col-10 d-flex align-items-end">
                            <h3 class="fw-semibold">Filter</h3>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <button class="btn" id="clear">
                                <img src="/storage/website-assets/trashcan.png" alt="reset filter" height="35px">
                            </button>
                        </div>
                    </div>

                    <form class="row filter mt-4">
                        @csrf
                        <div class="accordion accordion-flush" id="accordionExample">
                            {{-- Harga --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#filterHarga" aria-expanded="true" aria-controls="filterHarga">
                                        Price
                                    </button>
                                </h2>
                                <div id="filterHarga" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                                    <div class="accordion-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" id="minPrice" name='pmin' class="form-control" value='{{ request('daily_rate')[0] ?? '' }}' min ='0' placeholder="Min price">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" id="maxPrice" name='pmax' class="form-control" value='{{ request('daily_rate')[1] ?? '' }}' max='10000000' placeholder="Max price">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tipe --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterTipe" aria-expanded="true" aria-controls="filterTipe">
                                        Type
                                    </button>
                                </h2>
                                <div id="filterTipe" class="accordion-collapse collapse" aria-labelledby="headingOne" >
                                    <div class="accordion-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Luxury" name='type[]' id="Luxury"
                                                {{ is_array(request('type')) ? (in_array('Luxury', request('type')) ? 'checked' : '') : '' }}>
                                            <label class="form-check-label w-100" for="Luxury">Luxury</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Family" name='type[]' id="Family"
                                                {{ is_array(request('type')) ? (in_array('Family', request('type')) ? 'checked' : '') : '' }}>
                                            <label class="form-check-label w-100" for="Family">Family</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Minibus" name='type[]' id="Minibus"
                                                {{ is_array(request('type')) ? (in_array('Minibus', request('type')) ? 'checked' : '') : '' }}>
                                            <label class="form-check-label w-100" for="Minibus">Minibus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Brand --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterBrand" aria-expanded="true" aria-controls="filterBrand">
                                        Brand
                                    </button>
                                </h2>
                                <div id="filterBrand" class="accordion-collapse collapse" aria-labelledby="headingOne" >
                                    <div class="accordion-body">
                                        @foreach($brands as $brand)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $brand->brand }}" name='brand[]' id="{{ $brand->brand }}"
                                                    {{ is_array(request('brand')) ? (in_array($brand->brand, request('brand')) ? 'checked' : '') : '' }}>
                                                <label class="form-check-label w-100" for="{{ $brand->brand }}">{{ $brand->brand }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Passengers Capacity --}}
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterPenumpang" aria-expanded="true" aria-controls="filterPenumpang">
                                        Passenger Capacity
                                    </button>
                                </h2>
                                <div id="filterPenumpang" class="accordion-collapse collapse" aria-labelledby="headingOne" >
                                    <div class="accordion-body">
                                        <input type="number" id="minCapacity" name='cmin' class="form-control mb-3" value='{{ request('capacity')[0] ?? '' }}' min ='0' placeholder="Min passengers">
                                        <input type="number" id="maxCapacity" name='cmax' class="form-control mb-3" value='{{ request('capacity')[1] ?? '' }}' max='50' placeholder="Max passengers">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Vehicle List --}}
            <div class="col-md-8 mt-4 pe-md-0 tile border">
                <div class="col p-md-5 p-4">
                    
                    <h3 class="fw-semibold mb-3 text-center">Most Popular 🔥</h3>
                    @foreach($popular as $p)
                        <div class="row tile border mb-4">
                            <div class="col-md-6 p-4 most-popular-car">
                                <h4 class="fw-semibold mb-4 ms-md-3">{{ $p->brand . ' ' . $p->model }}</h4>
                                <img src="{{ $p->vehicle_image }}" alt="{{ $p->vehicle_image }}" class="w-100 img-fluid car-img">
                                <h3 class="mt-3 ms-md-3 fw-semibold text-primary">
                                    Rp {{ number_format($p->daily_rate, 0, ',', '.') }}<span class="text-primary-300 fs-6">/day</span>
                                </h3>
                            </div>
    
                            <div class="col-md-3 col-6 vstack gap-2 d-flex flex-column align-items-center justify-content-center ps-4 pe-1 py-md-3 pb-3">
                                <div class="tile highlight h-one p-3">
                                    <img src="/storage/website-assets/power.png" alt="" height="60px">
                                    <h6 class="fw-semibold mt-3 mb-0">{{ $p->HP }} hp</h6>
                                </div>
                                <div class="tile highlight h-two p-3">
                                    <img src="/storage/website-assets/torque.png" alt="" height="60px">
                                    <h6 class="fw-semibold mt-3 mb-0">{{ $p->torque }} Nm</h6>
                                </div>
                            </div>
    
                            <div class="col-md-3 col-6 vstack gap-2 d-flex flex-column align-items-center justify-content-center ps-1 pe-4 py-md-3 pb-3">
                                <div class="tile highlight h-three p-3">    
                                    @if ($p->vehicle_type == 'Luxury') 
                                        <img src="/storage/website-assets/top_speed.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0">{{ $p->top_speed }} km/h</h6>
                                    @else
                                        <img src="/storage/website-assets/passengers.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0">{{ $p->capacity }} persons</h6>
                                    @endif
                                </div>
                                <div class="tile highlight h-four p-3">
                                    @if ($p->vehicle_type == 'Luxury')
                                        <img src="/storage/website-assets/acceleration.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0 text-center">{{ $p->acceleration }} s<br> (0-100km/h)</h6>
                                    @else
                                        <img src="/storage/website-assets/luggage.png" alt="" height="60px">
                                        <h6 class="fw-semibold mt-3 mb-0 text-center">{{ $p->trunk }} large bags</h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                
                    {{-- Search Bar and Sort By Button --}}
                    <div class="row">
                        <div class="col-md-8 col-6 search-container">
                            <button id="search" class="btn p-0">
                                <i class="position-absolute"><i class="fa-solid fa-magnifying-glass"></i></i>
                            </button>
                            <input type="text" class="form-control" name="search" id="searchbar" placeholder="Search..." value="{{ old('search') }}">
                        </div>
                        <div class="col-md-4 col-6">
                            <select class="form-select" id="sort" name='sort'>
                                <option value="brandasc"><i class="bi bi-sort-alpha-up"></i> Nama A-Z</option>
                                <option value="branddesc"><i class="bi bi-sort-alpha-up"></i> Nama Z-A</option>
                                <option value="pmin" selected>Harga Terendah</option>
                                <option value="pmax">Harga Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    {{-- Vehicle List --}}
                    <div class="row cars">
                        @if($cars->count())
                            @foreach($cars as $car)
                                <div class="col-12 tile border mt-3">
                                    <div class="row p-3">
                                        <div class="col-md-6 px-3 d-flex justify-content-center">
                                            <img src="{{ $car->vehicle_image }}" alt="{{ $car->model }}" class="h-100 img-fluid car-img">
                                        </div>
        
                                        <div class="col-md-6 d-flex flex-column justify-content-center">
                                            <h6 class="fw-semibold">{{ $car->brand . ' ' . $car->model }}</h6>
                                            <h4 class="fw-semibold text-primary">
                                                Rp {{ number_format($car->daily_rate, 0, ',', '.') }}/day
                                            </h4>
                                            <span class="badge text-dark d-flex align-items-center justify-content-start">
                                                <img src="/storage/website-assets/group.png" alt="" height="25px">
                                                <span class="ps-2 fs-6">{{ ' ' . $car->capacity}}</span>
                                                <img src="/storage/website-assets/baggage.png" alt="" height="25px" class="ps-3">
                                                <span class="ps-2 fs-6">{{ ' ' . $car->trunk }}</span>
                                            </span>
        
                                            <a href="/rent/vehicles/{{ $car->model }}"><button class="btn btn-primary w-50 mt-3">Select</button></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <h5 class="text-center">No vehicle found</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="col p-5 tile border filter-container">
                <div class="row">
                    <div class="col-10 d-flex align-items-end">
                        <h3 class="fw-semibold">Filter</h3>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <button class="btn" id="clear">
                            <img src="/storage/website-assets/trashcan.png" alt="reset filter" height="35px">
                        </button>
                    </div>
                </div>

                <form action="" class="filter">
                    @csrf
                    {{-- Harga --}}
                    <p class='my-3'><strong>Price</strong></p>
                    <div class="input-group mb-3 col-6">
                        <span class="input-group-text">Rp</span>
                        <input type="number" id="minPrice" name='pmin' class="form-control" value='{{ request('daily_rate')[0] ?? '' }}' min ='0' placeholder="Min price">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Rp</span>
                        <input type="number" id="maxPrice" name='pmax' class="form-control" value='{{ request('daily_rate')[1] ?? '' }}' max='10000000' placeholder="Max price">
                    </div>

                    {{-- Type --}}
                    <hr class="my-4">
                    <p class='my-3'><strong>Type</strong></p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Luxury" name='type[]' id="Luxury"
                            {{ is_array(request('type')) ? (in_array('Luxury', request('type')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="Luxury">Luxury</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Family" name='type[]' id="Family"
                            {{ is_array(request('type')) ? (in_array('Family', request('type')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="Family">Family</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Minibus" name='type[]' id="Minibus"
                            {{ is_array(request('type')) ? (in_array('Minibus', request('type')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="Minibus">Minibus</label>
                    </div>

                    {{-- Brand --}}
                    <hr class="my-4">
                    <p class='my-3'><strong>Brand</strong></p>
                    @foreach($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $brand->brand }}" name='brand[]' id="{{ $brand->brand }}"
                                {{ is_array(request('brand')) ? (in_array($brand->brand, request('brand')) ? 'checked' : '') : '' }}>
                            <label class="form-check-label w-100" for="{{ $brand->brand }}">{{ $brand->brand }}</label>
                        </div>
                    @endforeach

                    {{-- Transmission --}}
                    <hr class="my-4">
                    <p class='my-3'><strong>Transmission</strong></p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="manual" name='transmission[]' id="manual" {{ is_array(request('transmission')) ? (in_array('manual', request('transmission')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="manual">Manual</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="matic" name='transmission[]' id="matic" {{ is_array(request('transmission')) ? (in_array('matic', request('transmission')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="matic">Matic</label>
                    </div>

                    {{-- Passengers --}}
                    <hr class="my-4">
                    <p class='my-3'><strong>Passengers</strong></p>
                    <input type="number" id="minCapacity" name='cmin' class="form-control mb-3" value='{{ request('capacity')[0] ?? '' }}' min ='0' placeholder="Min passengers">
                    <input type="number" id="maxCapacity" name='cmax' class="form-control mb-3" value='{{ request('capacity')[1] ?? '' }}' max='50' placeholder="Max passengers">
                </form>
            </div>
        </div>
      </div>

    {{-- Back to top button --}}
    <a href="#"><button class="btn btn-circle btn-primary position-fixed text-light p-3 top-shortcut"><i class="fa-solid fa-arrow-up fa-xl"></i></button></a>

    <script src="/js/filter.js"></script>
@endsection