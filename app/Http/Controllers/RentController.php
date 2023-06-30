<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Rent;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\Location;
use App\Models\Staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    protected $vehicle;
    protected $vehicleModel;
    protected $staff;

    public function __construct() {
        $this->vehicle = new Vehicle();
        $this->vehicleModel = new VehicleModel();
        $this->staff = new Staff();
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function admin() {
        return $this->belongsTo(Staff::class, 'admin_id');
    }

    public function driver() {
        return $this->belongsTo(Staff::class, 'driver_id');
    }

    public function index() {
        return view('user.rent.index', [
            'title' => 'My Bookings'
        ]);
    }

    public function chooseSchedule() {
        session()->forget('rent_data');
        return view('user.rent.schedule', [
            'title' => 'Rent A Car!',
            'locations' => Location::all(),
        ]);
    }

    public function setSchedule(Request $request) {
        $request->validate([
            'location' => 'required',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Add rent schedule and location into session
        $rent_data = (session()->has('rent_data')) ? session()->get('rent_data') : array();
        $rent_data['location_id'] = $request->location;
        $rent_data['start_date'] = $request->start_date;
        $rent_data['end_date'] = $request->end_date;
        session()->put('rent_data', $rent_data);

        return redirect()->route('rent-vehicle');
    }

    public function chooseVehicle() {
        $filter = [
            'location_id' => session()->get('rent_data')['location_id'],
            'sort' => 'pmin',
        ];

        return view('user.rent.vehicles', [
            'title' => 'Pick a vehicle',
            'cars' => $this->vehicleModel->fetch_cars($filter),
            'brands' => $this->vehicleModel->fetch_brands(),
            'popular' => $this->vehicleModel->most_popular_model($filter),
        ]);
    }

    public function filterVehicle(Request $request) {
        $filter = $request->filters;
        $filter['location_id'] = session()->get('rent_data')['location_id'];

        return $this->vehicleModel->fetch_cars($filter);
    }

    public function viewVehicle($model) {
        return view('user.rent.vehicle', [
            'title' => 'Rent ' . $model,
            'car' => $this->vehicleModel->firstWhere('model', $model),
            'transmissions' => $this->vehicleModel->getTransmissions($model),
        ]);
    }

    public function checkVehicle(Request $request, $model) {
        $validator = Validator::make($request->all(), [
            'transmission' => 'required',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]); 
        
        // If there's error in validation
        if ($validator->fails()) {
            $errors = array();
            $errors['error'] = $validator->errors();
            return $errors;
        }

        // Update session value
        $rent_data = session()->get('rent_data');
        $rent_data['start_date'] = $request->start_date;
        $rent_data['end_date'] = $request->end_date;
        session()->put('rent_data', $rent_data);

        return $this->vehicle->getAvailableVehicles($model, $request->transmission);
    }

    public function setVehicleModel(Request $request, $model) {
        $vehicle = $this->checkVehicle($request, $model);

        // Add vehicle data into session
        if ($vehicle) {
            $rent_data = session()->get('rent_data');
            $rent_data['vehicle_model'] = $model;
            $rent_data['vehicle_transmission'] = $request->transmission;
            session()->put('rent_data', $rent_data);
            return redirect()->route('rent-detail');
        }
        else
            return back()->with('error', 'Kendaraan yang anda pilih sudah tidak tersedia, silahkan pilih kendaraan yang lain!');
    }

    public function contactForm() {
        $modelId = VehicleModel::firstWhere('model', session()->get('rent_data')['vehicle_model']);

        return view('user.rent.form', [
            'title' => 'Fill Contact Detail',
            'car' => $this->vehicle->getSelectedVehicleInfo($modelId->id),
            'location' => Location::firstWhere('id', session()->get('rent_data')['location_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $this->store($request);
        return view('user.rent.create', [
            'title' => 'Sewa Mobil',
            'location' => Location::where('id', $request->session()->get('location_id'))->get()->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'renter_name' => 'min:3|max:255',
            'renter_phone' => 'numeric|min:8',
            'renter_email' => 'required|email:dns',
            'driver_name' => 'min:3|max:255',
            'driver_phone' => 'numeric|min:8',
            'driver_email' => 'required|email:dns',
            'driver_identity' => 'image|file|max:2048',
            'driver_license' => 'image|file|max:2048',
            'tnc-agreement' => 'accepted',
            'privacy-policy-agreement' => 'accepted',
        ]);
        
        $rent_data = session()->get('rent_data');
        
        // Check once again for available vehicles
        $availableVehicles = $this->vehicle->getAvailableVehicles($rent_data['vehicle_model'], $rent_data['vehicle_transmission']);

        if ($availableVehicles->count() > 0)
            $rent_data['vehicle_id'] = $availableVehicles->first()->id;
        else
            return back()->with('Error', 'Kendaraan yang anda pilih sudah tidak tersedia lagi, silahkan memilih kendaraan yang lain!');
        
        // Store files
        if ($request->file('driver_identity') && $request->file('driver_license')) {
            $validatedData['driver_identity'] = $request->file('driver_identity')->store('upload_KTP');
            $validatedData['driver_license'] = $request->file('driver_license')->store('upload_SIM');
        }
        
        // Fill remaining Rent field
        try {
            $rent_data['start_date'] = new Datetime(session()->get('rent_data')['start_date']);
            $rent_data['end_date'] = new Datetime(session()->get('rent_data')['end_date']);
            $rent_data['renter_name'] = $validatedData['renter_name'];
            $rent_data['renter_phone'] = $validatedData['renter_phone'];
            $rent_data['renter_email'] = $validatedData['renter_email'];
            $rent_data['driver_name'] = $validatedData['driver_name'];
            $rent_data['driver_phone'] = $validatedData['driver_phone'];
            $rent_data['driver_email'] = $validatedData['driver_email'];
            $rent_data['driver_identity'] = $validatedData['driver_identity'];
            $rent_data['driver_license'] = $validatedData['driver_license'];
            $rent_data['rent_number'] = 'RR' . (fake()->randomNumber(8));
            $rent_data['user_id'] = auth()->user()->id;
            $rent_data['admin_id'] = $this->staff->getAdmin()->id;
            $rent_data['total_price'] = $this->vehicleModel->firstWhere('model', $rent_data['vehicle_model'])->daily_rate * 
                                        $this->dateDiff($rent_data['end_date']->format("U"), $rent_data['start_date']->format("U"));
            $rent_data['status_id'] = 1;
            
            unset($rent_data['vehicle_model'], $rent_data['vehicle_transmission']);
            
            DB::beginTransaction();
            try {
                // Insert Rent
                Rent::insert($rent_data);
    
                // Update vehicle status
                $this->vehicle->where('id', $rent_data['vehicle_id'])->update(['is_available' => 0]);
    
                // Commit changes
                DB::commit();
    
                // Update session info
                // session()->forget('rent_data');
                session()->put('rent_number', $rent_data['rent_number']);
    
                return redirect()->route('rent-payment', ['rent_number' => $rent_data['rent_number']]);
            }
            catch(Exception $e) {
                // Rollback changes
                dd($e);
                DB::rollback();
    
                // Delete uploaded files
                Storage::delete('/' . $rent_data['driver_identity']);
                Storage::delete('/' . $rent_data['driver_license']);
    
                return redirect()->back()->withInput()->with('Error', 'Terjadi kesalahan dalam menginput data, silahkan mencoba lagi');
            }
        }
        
        catch(Exception $e) {
            // Delete uploaded files
            Storage::delete('/' . $rent_data['driver_identity']);
            Storage::delete('/' . $rent_data['driver_license']);
            return back()->with('Error', 'TEs Terjadi kesalahan dalam menginput data, silahkan mencoba lagi');
        }
    }

    public function cancel($id) {
        $rent = Rent::firstWhere('user_id', auth()->user()->id)->where('id', $id)->get()->first();

        if ($rent->count() > 0 && ($this->dateDiff($rent->start_date, now()) >= 1 || $rent->status_id == 1)) {
            DB::beginTransaction();
            try {
                // Update Rent Status
                Rent::where('id', $id)->update(['status_id' => 6]);

                // Update vehicle status
                $this->vehicle->where('id', $rent->vehicle_id)->update(['is_available' => 1]);
                
                // Commit changes
                DB::commit();

                // Delete uploaded files
                Storage::delete('/' . $rent->driver_identity);
                Storage::delete('/' . $rent->driver_license);

                return back()->with('Success', 'Your booking has been cancelled!');
            }
            catch(Exception $e) {
                // Rollback changes
                DB::rollback();

                return back()->with('Error', 'Error cancelling your order, please try again!');
            }
        }

        // else if (date_diff(new Datetime($rent->start_date), now())->d < 1)
        else if ($this->dateDiff(now()->format("U"), $rent->start_date->format("U")) < 1)
            return back()->with('Error', "Can't cancel rent that will start in less than a day!");

        abort(403);
    }

    function dateDiff($d1, $d2) {
        // dd($d1 . ' ' . $d2);
        $delta = $d1 - $d2;
        // dd($delta / 86400);
        // dd(floor($delta / 86400));
        return floor($delta / 86400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Rent $rent)
    {
        return view('rent.show', [
            'title' => 'E-ticket Anda',
            'rent' => $rent
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy($rentId)
    {
        
    }
}
