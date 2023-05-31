<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function vehicle() {
        return $this->hasMany(Vehicle::class, 'location_id');
    }

    public function rent() {
        return $this->hasMany(Rent::class);
    }
}
