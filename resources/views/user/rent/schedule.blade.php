@extends('user.layouts.main')

@section('style')
	<style>
		/* @media screen and (max-width: 768px) {
			.pc-only {
				display: none !important;
			}
		} */
	</style>
@endsection

@section('container')
    <div class="container py-4">
        {{-- Steps --}}
        @include('user.partials.form-step')

        <div class="row mt-4">
            <div class="col-lg-6 p-5 d-flex justify-content-center pc-only">
                <img src="/website-assets/pick-date.png" alt="Schedule" class="img-fluid px-5">
            </div>
    
            <div class="col-lg-6">
                <form action="{{ route('set-schedule') }}" method="post" class="p-5 tile">
                    @csrf
                    <label for="location" class="form-label fw-semibold">Location</label>
                    <select class="form-select mb-4 @error('location') is-invalid @enderror" aria-label="Default select example" id='location' name="location" value="{{ session()->get('rent_data')['location'] ?? old('location') }}">
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                        @endforeach
                    </select>

                    @error('location')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label fw-semibold">Pick Up</label>
                            <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name='start_date' value="{{ session()->get('rent_data')['start_date'] ?? date('Y/m/d', strtotime('tomorrow')) }}">

                            @error('start_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-semibold">Return</label>
                            <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name='end_date' value="{{ session()->get('rent_data')['end_date'] ?? old('end_date') ?? date('Y/m/d', strtotime('+4 day')) }}">

                            @error('end_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-2">Browse Vehicle</button>
                </form>
            </div>
        </div>
    </div>
@endsection