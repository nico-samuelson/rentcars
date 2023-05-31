<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $rents;
    protected $vehicles;
    protected $vehicleModels;
    protected $employees;
    protected $users;

    public function __construct() {
        $this->rents = new Rent();
        $this->vehicles = new Vehicle();
        $this->vehicleModels = new VehicleModel();
        $this->employees = new Staff();
        $this->users = new User();
    }

    public function index() {
        $user = auth('admin')->user();
        $data = array();
        $data['week_revenue'] = $this->rents->thisWeekRevenue($user);
        $data['num_of_rents'] = $this->rents->thisWeekRent($user);
        $data['available_vehicle'] = $this->vehicles->availableVehicle($user);
        $data['new_users'] = $this->users->newUser($user);
        $data['monthly_revenue'] = $this->rents->monthlyRevenue($user);
        $data['monthly_rent'] = $this->rents->monthlyRent($user);
        // dd($data['monthly_rent']['quantity'][4]);

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'data' => $data,
        ]);
    }

    public function getMonthlyRevenue() {
        return json_encode($this->rents->monthlyRevenue(auth('admin')->user()));
    }

    public function getMonthlyRent() {
        return json_encode($this->rents->monthlyRent(auth('admin')->user()));
    }
}
