<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rent() {
        return $this->hasMany(Rent::class);
    }

    public function newUser($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $result = array();
            $thisWeek = $this->whereBetween('created_at', [now()->startOfWeek(), now()]);
            $lastWeek = $this->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]);
            
            $thisWeek = $thisWeek->count();
            $lastWeek = $lastWeek->count();
            $result[] = $thisWeek;
            $result[] = $lastWeek == 0 ? ($thisWeek == 0 ? 0 : 100) : ($thisWeek / $lastWeek - 1) * 100;
    
            // dd($result);
            return $result;
        }

        return array(0, 0);
    }

    public function monthlyNewUser($employee) {
        if ($employee->access_lvl >= 1 && $employee->access_lvl <= 5) {
            $labels = array();
            $newUsers = array();
    
            $data = $this
            ->select(DB::raw("count(*) as new_user"), DB::raw("(DATE_FORMAT(created_at, '%Y-%m')) as time"));
    
            if ($employee->access_lvl < 5)
                $data = $data->where('location_id', $employee->location_id);

            $data = $data->groupBy("time")->orderBy('time', 'desc')->limit(5)->get();
    
            foreach($data as $d) {
                $labels[] = $d->time;
                $newUsers[] = $d->newUsers;
            }

            dd($newUsers);

            $labels = array_reverse($labels);
            $newUsers = array_reverse($newUsers);
            return json_encode(array('labels' => $labels, 'quantity' => $newUsers));
        }
        // $result = array();
        return json_encode(array('labels' => array(), 'quantity' => array()));
    }
}
