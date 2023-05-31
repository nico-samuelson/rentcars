<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Rent extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function admin() {
        return $this->belongsTo(Staff::class, 'admin_id');
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function getRouteKeyName()
    {
        return 'rent_number';
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function rentStatus() {
        return $this->belongsTo(RentStatus::class, 'status_id');
    }

    public function getOngoingRent() {
        return $this->where('user_id', auth()->user()->id)->whereIn('status_id', [0, 1, 2, 3])->orderby('updated_at', 'desc')->get();
    }

    public function getPastRent() {
        return $this->where('user_id', auth()->user()->id)->whereNotIn('status_id', [0, 1, 2, 3])->orderby('updated_at', 'desc')->get();
    }

    public function getRentByStatus($statuses) {
        return $this->where('user_id', auth()->user()->id)->whereIn('status_id', $statuses)->orderBy('updated_at', 'desc')->get();
    }

    public function thisWeekRevenue($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $result = array();
            $thisWeek = $this->whereBetween('created_at', [now()->startOfWeek(), now()]);
            $lastWeek = $this->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);

            // For BOD, BOC, and Shareholders
            if ($employee->access_lvl < 5) {
                $thisWeek = $thisWeek->where('location_id', $employee->location_id);
                $lastWeek = $lastWeek->where('location_id', $employee->location_id);
            }

            $thisWeek = $thisWeek->sum('total_price');
            $lastWeek = $lastWeek->sum('total_price');
            $result[] = intval($thisWeek);
            $result[] = $lastWeek == 0 ? ($thisWeek = 0 ? 0 : 100) : ($thisWeek / $lastWeek - 1) * 100;

            // dd($result);
            return $result;
        }

        return array(0, 0);
    }

    public function thisWeekRent($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $result = array();
            $thisWeek = $this->whereBetween('created_at', [now()->startOfWeek(), now()]);
            $lastWeek = $this->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
            
            // For BOD, BOC, and Shareholders
            if ($employee->access_lvl < 5) {
                $thisWeek = $thisWeek->where('location_id', $employee->location_id);
                $lastWeek = $lastWeek->where('location_id', $employee->location_id);
            }
            
            $thisWeek = $thisWeek->count();
            $lastWeek = $lastWeek->count();
            $result[] = $thisWeek;
            $result[] = $lastWeek == 0 ? ($thisWeek == 0 ? 0 : 100) : ($thisWeek / $lastWeek - 1) * 100;
    
            // dd($result);
            return $result;
        }

        return array(0, 0);
    }

    public function monthlyRevenue($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $labels = array();
            $revenue = array();
    
            $data = $this
            ->select(DB::raw("sum(total_price) as revenue"), DB::raw("(DATE_FORMAT(start_date, '%Y-%m')) as time"));
    
            if ($employee->access_lvl < 5)
                $data = $data->where('location_id', $employee->location_id);

            $data = $data->groupBy("time")->orderBy('time', 'desc')->limit(5)->get();
    
            foreach($data as $d) {
                $labels[] = date_format(date_create_from_format('Y-m', $d->time), 'M Y');
                $revenue[] = $d->revenue;
            }

            $labels = array_reverse($labels);
            $revenue = array_reverse($revenue);
            return array('labels' => $labels, 'quantity' => $revenue);
        }

        return array('labels' => array(), 'quantity' => array());
    }

    public function monthlyRent($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $labels = array();
            $count = array();
    
            $data = $this
            ->select(DB::raw("count(*) as count"), DB::raw("(DATE_FORMAT(start_date, '%Y-%m')) as time"));
    
            if ($employee->access_lvl < 5)
                $data = $data->where('location_id', $employee->location_id);

            $data = $data->groupBy("time")->orderBy('time', 'desc')->limit(5)->get();
    
            foreach($data as $d) {
                $labels[] = date_format(date_create_from_format('Y-m', $d->time), 'M Y');
                $count[] = $d->count;
            }

            $labels = array_reverse($labels);
            $count = array_reverse($count);

            // dd(array('labels' => $labels, 'quantity' => $count));
            return array('labels' => $labels, 'quantity' => $count);
        }

        return array('labels' => array(), 'quantity' => array());
    }
}
