<?php

namespace App\Models;

use App\Models\Rent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Admin as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $guard = 'admin';
    protected $table = 'staff';

    public function rent() {
        return $this->hasMany(Rent::class, 'id');
    }

    public function getAdmin() {
        return $this->where('department_id', 4)->where('position', 'Staff')->first();
    }
}
