<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Location;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    public function filter(Request $request) 
    {
        // $cars = Vehicle::fetch_cars($request);

        // $request->session()->reflash();
        // $request->session()->put('location_id', $request->location_id);
        // $request->session()->put('start_date', $request->start_date);
        // $request->session()->put('start_time', $request->start_time);
        // $request->session()->put('end_date', $request->end_date);
        // $request->session()->put('end_time', $request->end_time);

        // return $cars;
    }

    public function showFilteredData(Request $request) {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *  
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Vehicle $vehicle)
    {
        // dd($request);

        $request->session()->put('car', $vehicle);

        return redirect()->route('rent.create');
        // return view('vehicle', [
        //     'title' => 'Rent',
        //     'car' => $vehicle,
        //     'location' => Location::where('id', $request->session()->get('location_id'))->get()->toArray()
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
