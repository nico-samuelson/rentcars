<div class="change-schedule tile mt-4 py-md-4 px-md-5 p-3">
    {{-- Toggler --}}
    <div class="col hstack gap-3">
        <div class="w-75">
            <p class="fw-semibold fs-4 mb-0">Car Rental</p>
            <p class="text-muted mb-0 fs-6">{{ session()->get('rent_data')['location']['location_name'] . ' | ' . date_format(new Datetime(session()->get('rent_data')['start_date']), 'D, d M Y') . ' - ' . date_format(new Datetime(session()->get('rent_data')['end_date']), 'D, d M Y') }}</p>
        </div>
        <div class="w-25 d-flex justify-content-end d-none d-lg-flex">
            <button class="btn btn-primary px-md-5" id="dropdown-toggler">Edit</button>
        </div>
        <div class="w-25 d-flex justify-content-end d-none d-lg-flex">
            <button class="btn btn-primary px-md-5" id="dropdown-toggler">Edit</button>
        </div>
    </div>

    {{-- Dropdown --}}
    <div class="change-schedule-dropdown mt-4">
        <form action="{{ route('set-schedule') }}" method="post">
            @csrf
            @error('location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <div class="row">
                <div class="col-md-3 mb-3 mb-md-0">
                    <label for="location" class="form-label fw-semibold">Location</label>
                    <select class="form-select @error('location') is-invalid @enderror" aria-label="Default select example" id='location' name="location" value="{{ session()->get('rent_data')['location']['id'] ?? old('location') }}">
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label for="start_date" class="form-label fw-semibold">Start</label>
                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name='start_date' value="{{ session()->get('rent_data')['start_date'] ?? date('Y/m/d', strtotime('tomorrow')) }}">

                    @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <label for="end_date" class="form-label fw-semibold">End</label>
                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name='end_date' value="{{ session()->get('rent_data')['end_date'] ?? old('end_date') ?? date('Y/m/d', strtotime('+4 day')) }}">

                    @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100 py-2">Browse Vehicle</button>
                </div>
            </div>

        </form>
    </div>
</div>