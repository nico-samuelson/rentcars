<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function location() {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function vehicleModel() {
        return $this->belongsto(VehicleModel::class, 'model_id');
    }

    public function getRouteKeyName() {
        return 'model';
    }

    public function getAvailableVehicles($model, $transmission) {
        $modelId = VehicleModel::select('id')->where('model', $model)->get();

        $vehicles = $this->where('model_id', $modelId[0]->id)
        ->where('transmission', $transmission)
        ->where('location_id', session()->get('rent_data')['location_id'])
        ->where('is_available', 1)
        ->whereNotExists(function($q) {
            $q->select('vehicle_id')
            ->from('rents')
            ->whereColumn('rents.vehicle_id', 'vehicles.id')
            ->where(function($q) {
                $q->whereBetween('rents.start_date', [session()->get('rent_data')['start_date'], session()->get('rent_data')['end_date']])
                
                ->orWhere(function($q){
                    $q->whereBetween('rents.end_date', [session()->get('rent_data')['start_date'], session()->get('rent_data')['end_date']]);
                })

                ->orWhere(function($q){ 
                    $q->where('rents.start_date', '<=', session()->get('rent_data')['start_date'])
                        ->where('rents.end_date', '>=', session()->get('rent_data')['end_date']);
                });
            })
            ->whereNotIn('status_id', [5, 6, 7]);
        })
        ->get();

        return $vehicles;
    }

    public function availableVehicle($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $result = array();
            $vehicles = $this->where('is_available', true);
    
            if ($employee->access_lvl < 5)
                $vehicles = $vehicles->where('location_id', $employee->location_id);
    
            $result[] = $vehicles->count();
            $result[] = $this->all()->count();
            
            return $result;
        }

        return array(0, 0);
    }

    public function getSelectedVehicleInfo($modelId) {
        return $this->where('model_id', $modelId)->where('transmission', session()->get('rent_data')['vehicle_transmission'])->first();
    }
}