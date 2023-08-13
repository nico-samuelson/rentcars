<?php

namespace App\Models;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'model_id');
    }

    public function fetch_cars_by_models($type = '')
    {
        if ($type == '')
            return $this->select('brand', 'model', 'capacity', 'trunk', 'vehicle_image')
                ->distinct()
                ->get();

        else if ($type == 'Luxury')
            return $this->select('brand', 'model', 'capacity', 'trunk', 'vehicle_image')
                ->distinct()
                ->where('vehicle_type', $type)
                ->get();

        else
            return $this->select('brand', 'model', 'capacity', 'trunk', 'vehicle_image')
                ->distinct()
                ->where('vehicle_type', $type)
                ->get();
    }

    public function fetch_brands()
    {
        return $this->select('brand')->distinct()->get();
    }

    public function fetch_cars(array $filters)
    {
        $cars =  $this
            ->join('vehicles', 'vehicles.vehicle_model_id', '=', 'vehicle_models.id')
            ->select('brand', 'model', 'transmission', 'vehicle_image', 'vehicle_type', 'capacity', 'trunk', 'location_id', DB::raw('(SELECT daily_rate FROM vendor_vehicle_rates WHERE vehicles.vehicle_model_id = vendor_vehicle_rates.vehicle_model_id ORDER BY daily_rate ASC LIMIT 1) AS daily_rate'), DB::raw("(COUNT(DISTINCT(vendor_id))) AS num_vendors"))->distinct()
            ->where('is_available', true);

        $cars = $this
            ->scopeFilter($cars, $filters)
            ->groupBy('vehicle_model_id', 'brand', 'model', 'vehicle_image', 'vehicle_type', 'capacity', 'trunk', 'location_id', 'transmission')
            ->get();

        // dd($cars);
        return $cars;
    }

    public function scopeFilter($q, array $filters)
    {
        // dd($filters);
        $q->when($filters['location_id'] ?? false, fn ($q, $location) => $q->where('location_id', $location));

        $q->when($filters['brand'] ?? false, fn ($q, $brand) => $q->whereIn('brand', $brand));

        $q->when($filters['type'] ?? false, fn ($q, $type) => $q->whereIn('vehicle_type', $type));

        $q->when($filters['transmission'] ?? false, fn ($q, $transmission) => $q->whereIn('transmission', $transmission));

        $q->when($filters['capacity'] ?? false, fn ($q, $capacity) => $q->whereBetween('capacity', $capacity));

        $q->when($filters['vendor'] ?? false, fn($q, $vendor) => $q->whereIn('vendor_id', $vendor));

        $q->when($filters['price'] ?? false, fn ($q, $price) => $q->whereBetween(DB::raw('(SELECT daily_rate FROM vendor_vehicle_rates WHERE vehicles.vehicle_model_id = vendor_vehicle_rates.vehicle_model_id ORDER BY daily_rate ASC LIMIT 1)'), $price));

        $q->when($filters['sort'] ?? false, function ($q, $sort) {
            if ($sort == 'brandasc') {
                $q->orderBy('brand', 'asc');
                $q->orderBy('model', 'asc');
            } else if ($sort == 'branddesc') {
                $q->orderBy('brand', 'desc');
                $q->orderBy('model', 'desc');
            } else if ($sort == 'cmin') {
                $q->orderBy('capacity', 'asc');
            } else if ($sort == 'cmax') {
                $q->orderBy('capacity', 'desc');
            } else if ($sort == 'pmin') {
                $q->orderBy('daily_rate', 'asc');
            } else if ($sort == 'pmax') {
                $q->orderBy('daily_rate', 'desc');
            }
        });
        $q->when($filters['search'] ?? false, fn ($q, $search) => $q->where('model', 'like', '%' . $search . '%'));

        return $q;
    }

    public function most_popular_model(array $filters)
    {
        $topmodel = DB::select(
            "SELECT model_id, sum((SELECT count(*) from rents r where r.vehicle_id = v.id AND v.id IN (SELECT id from vehicles x where x.model_id = v.model_id) AND v.location_id = ?)) AS rent_count FROM vehicles v GROUP BY model_id ORDER BY `rent_count` DESC LIMIT 1",
            [$filters['location_id']]
        );

        // dd($topmodel);

        return $this->where('id', $topmodel[0]->model_id)->get();
    }

    public function getTransmissions($model)
    {
        return $this
            ->join('vehicles', 'vehicles.model_id', '=', 'vehicle_models.id')
            ->select('transmission')
            ->distinct()
            ->where('location_id', session()->get('rent_data')['location_id'])
            ->where('model', $model)
            ->get();
    }
}
