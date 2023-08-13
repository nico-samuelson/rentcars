@extends('user.layouts.main')

@section('style')
    <style>
        #sort {
            color: #fff;
            background-color: var(--primary);
        }

        .input-group-text {
            background-color: transparent !important;
            border: 2px solid #88888850 !important;
            color: #aaa !important;
            margin-right: -1px !important;
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
            border-bottom : 2px solid #aaa !important;
            border-radius: 0;
        }

        .top-shortcut {
            bottom: 20px;
            right: 20px;
        }

        .cars .tile {
            border: 1px solid #88888850 !important;
        }

        .dropdown-menu {
            width: 25vw !important;
            z-index: 5000 !important;
        }

        @media screen and (max-width:992px) {
            .filter-large {
                display: none !important;
            }
        }
    </style>
@endsection

@section('container')
    <div class="container py-4">
        @include('user.partials.form-step')
        @include('user.partials.schedule')

        <div class="row mx-0 py-3">
            {{-- Filter on large screen --}}
            <form class="hstack gap-3 filter-large d-none d-lg-flex px-0 mt-2">
                @csrf
                <div>
                    <p class="mb-0">Filter: </p>
                </div>
                {{-- Price Filter --}}
                <div class="dropdown">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Price
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-dark p-3">
                        <li class="mb-3">Price</li>
                        <li>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="minPrice" name='pmin' class="form-control" value='{{ request('daily_rate')[0] ?? '' }}' min ='0' placeholder="Min price">
                            </div>
                        </li>
                        <li>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="maxPrice" name='pmax' class="form-control" value='{{ request('daily_rate')[1] ?? '' }}' max='10000000' placeholder="Max price">
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Capacity Filter --}}
                <div class="dropdown">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Passenger
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-dark p-3">
                        <li class="mb-3">Passenger</li>
                        <li>
                            <input type="number" id="minCapacity" name='cmin' class="form-control mb-3" value='{{ request('capacity')[0] ?? '' }}' min ='0' placeholder="Min passengers">
                        </li>
                        <li>
                            <input type="number" id="maxCapacity" name='cmax' class="form-control" value='{{ request('capacity')[1] ?? '' }}' max='50' placeholder="Max passengers">
                        </li>
                    </ul>
                </div>

                {{-- Type Filter --}}
                <div class="dropdown">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Car Type
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-dark p-3">
                        <li class="mb-3">CarType</li>
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
                    </ul>
                </div>

                {{-- Brand Filter --}}
                <div class="dropdown">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Brand
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-dark p-3">
                        <li class="mb-3">Brand</li>
                        @foreach($brands as $brand)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $brand->brand }}" name='brand[]' id="{{ $brand->brand }}"
                                    {{ is_array(request('brand')) ? (in_array($brand->brand, request('brand')) ? 'checked' : '') : '' }}>
                                <label class="form-check-label w-100" for="{{ $brand->brand }}">{{ $brand->brand }}</label>
                            </div>
                        @endforeach
                    </ul>
                </div>

                {{-- Vendor --}}
                <div class="dropdown">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vendor
                    </button>
                    
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end dropdown-menu-lg-start p-3">
                        <li class="mb-3">Vendor</li>
                        @foreach($vendors as $vendor)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $vendor->id }}" name='vendor[]' id="{{ $vendor->vendor_name }}"
                                    {{ is_array(request('vendor')) ? (in_array($vendor->vendor_name, request('vendor')) ? 'checked' : '') : '' }}>
                                <label class="form-check-label w-100" for="{{ $vendor->vendor_name }}">{{ $vendor->vendor_name }}</label>
                            </div>
                        @endforeach
                    </ul>
                </div>

                <div class="dropdown w-100 d-flex justify-content-end align-items-center">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort By
                    </button>
                      
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end p-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort1" value="cmin">
                            <label class="form-check-label" for="sort1">
                                Lowest Capacity
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort2" value="cmax">
                            <label class="form-check-label" for="sort2">
                                Highest Capacity
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort3" value="pmin">
                            <label class="form-check-label" for="sort3">
                                Lowest Price
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort4" value="pmax">
                            <label class="form-check-label" for="sort4">
                                Highest Price
                            </label>
                        </div>
                    </ul>
                </div>
            </form>

            {{-- Filter on small screen --}}
            <div class="hstack gap-3 d-lg-none px-0">
                {{-- Filter --}}
                <button class="btn btn-dark d-lg-none px-4 py-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
                    Filter
                </button>

                {{-- Sort By --}}
                <div class="dropdown w-100 d-flex justify-content-end align-items-center">
                    <button class="btn btn-dark px-4 dropdown-toggle py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sort By
                    </button>
                      
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end p-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort1" value="cmin">
                            <label class="form-check-label" for="sort1">
                                Lowest Capacity
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort2" value="cmax">
                            <label class="form-check-label" for="sort2">
                                Highest Capacity
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort3" value="pmin">
                            <label class="form-check-label" for="sort3">
                                Lowest Price
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" id="sort4" value="pmax">
                            <label class="form-check-label" for="sort4">
                                Highest Price
                            </label>
                        </div>
                    </ul>
                </div>
            </div>

            {{-- Vehicle List --}}
            <div class="col-12 mt-3 mt-md-4 pe-lg-0 tile">
                <div class="col p-lg-5 p-4">
                    {{-- Vehicle List --}}
                    <div class="row cars p-0">
                        @if($cars->count())
                            @foreach($cars as $car)
                                <div class="col-12 tile mt-3">
                                    <div class="row p-4 p-md-3 h-100">
                                        <div class="col-md-4 py-3 py-md-0 px-md-5 d-flex justify-content-center align-items-center">
                                            <img src="{{ $car->vehicle_image }}" alt="{{ $car->model }}" class="img-fluid car-img">
                                        </div>
        
                                        <div class="col-md-4 py-md-3 py-2 d-flex flex-column justify-content-start align-items-center align-items-md-start">
                                            <h5 class="fw-semibold mb-0 text-center text-md-start">{{ $car->brand . ' ' . $car->model }}</h5>

                                            <span class="badge fw-normal p-0 mt-md-3 mt-1 d-flex align-items-center justify-content-start">
                                                <img src="/website-assets/transmission.png" alt="" height="25px">
                                                <span class="ps-2 fs-6">{{ $car->transmission }}</span>
                                            </span>

                                            <span class="badge fw-normal p-0 mt-md-3 mt-1 d-flex align-items-center justify-content-start">
                                                <img src="/website-assets/people.png" alt="" height="25px" class="">
                                                <span class="ps-2 fs-6"> {{ $car->capacity }}</span>
                                                <img src="/website-assets/baggage.png" alt="" height="25px" class="ps-3">
                                                <span class="ps-2 fs-6"> {{ $car->trunk }}</span>
                                            </span>
                                            
                                            <p class="text-primary mt-md-3 mt-1 mb-0">{{ $car->num_vendors }} vendor tersedia</p>
                                        </div>

                                        <div class="col-md-4 py-md-3 d-flex flex-column justify-content-start align-items-center align-items-md-end align-items-start">
                                            <small class="text-end p-0 m-0">
                                                From
                                            </small>
                                            <h4 class="fw-semibold text-primary">
                                                Rp {{ number_format($car->daily_rate, 0, ',', '.') }}<small class="fw-normal text-light p-0 m-0"> /day</small>
                                            </h4>
                                            <a href="/rent/vehicles/{{ $car->model }}/{{ $car->transmission }}"><button class="btn btn-primary px-5 py-2 mt-3">Select</button></a>
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

    {{-- Filter Offcanvas --}}
    <div class="offcanvas text-bg-dark offcanvas-bottom p-3 px-md-5" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">Filter</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form class="filter-small">
                @csrf
                {{-- Price Filter --}}
                <p class="fs-5">Price</p>
                <div class="input-group mb-3">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="minPrice" name='pmin' class="form-control" value='{{ request('daily_rate')[0] ?? '' }}' min ='0' placeholder="Min price">
                </div>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" id="maxPrice" name='pmax' class="form-control" value='{{ request('daily_rate')[1] ?? '' }}' max='10000000' placeholder="Max price">
                </div>

                {{-- Capacity Filter --}}
                <p class="fs-5 mt-4">Passenger Capacity</p>
                <input type="number" id="minCapacity" name='cmin' class="form-control mb-3" value='{{ request('capacity')[0] ?? '' }}' min ='0' placeholder="Min passengers">
                <input type="number" id="maxCapacity" name='cmax' class="form-control" value='{{ request('capacity')[1] ?? '' }}' max='50' placeholder="Max passengers">

                {{-- Type Filter --}}
                <p class="fs-5 mt-4">Car Type</p>
                <div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="Luxury" name='type[]' id="Luxury"
                            {{ is_array(request('type')) ? (in_array('Luxury', request('type')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="Luxury">Luxury</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="Family" name='type[]' id="Family"
                            {{ is_array(request('type')) ? (in_array('Family', request('type')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="Family">Family</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="Minibus" name='type[]' id="Minibus"
                            {{ is_array(request('type')) ? (in_array('Minibus', request('type')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="Minibus">Minibus</label>
                    </div>
                </div>

                {{-- Brand Filter --}}
                <p class="fs-5 mt-4">Brand</p>
                @foreach($brands as $brand)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="{{ $brand->brand }}" name='brand[]' id="{{ $brand->brand }}" {{ is_array(request('brand')) ? (in_array($brand->brand, request('brand')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="{{ $brand->brand }}">{{ $brand->brand }}</label>
                    </div>
                @endforeach

                {{-- Vendor --}}
                <p class="fs-5 mt-4">Vendor</p>
                @foreach($vendors as $vendor)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="{{ $vendor->id }}" name='vendor[]' id="{{ $vendor->vendor_name }}"
                            {{ is_array(request('vendor')) ? (in_array($vendor->vendor_name, request('vendor')) ? 'checked' : '') : '' }}>
                        <label class="form-check-label w-100" for="{{ $vendor->vendor_name }}">{{ $vendor->vendor_name }}</label>
                    </div>
                @endforeach
            </form>
        </div>
    </div>

    {{-- Top Shortcut --}}
    <a href="#"><button class="btn btn-circle btn-primary position-fixed text-light p-3 top-shortcut"><i class="fa-solid fa-arrow-up fa-xl"></i></button></a>
@endsection

@section('script')
    <script src="/js/changeSchedule.js"></script>
    <script src="/js/filter.js"></script>
@endsection