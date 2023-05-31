<?php

namespace App\Http\Controllers;

use App\Models\CustomerTicket;
use Illuminate\Http\Request;
use App\Models\VehicleModel;
use App\Models\Location;

class HomeController extends Controller
{
    protected $vehicle_model;

    public function __construct()
    {
        $this->vehicle_model = new VehicleModel;
        session()->start();
    }

public function index() {
        return view('user.welcome', [
            'title' => 'Home',
            'cars' => $this->vehicle_model->fetch_cars_by_models('Luxury'),
            'locations' => Location::all()
        ]);
    }

    public function filterFleet($filter) {
        if ($filter == 'all')
            $cars = $this->vehicle_model->fetch_cars_by_models();
        else
            $cars = $this->vehicle_model->fetch_cars_by_models($filter);

        return $cars;
    }
}