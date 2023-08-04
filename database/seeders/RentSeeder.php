<?php

namespace Database\Seeders;

use App\Models\Rent;
use App\Models\User;
use App\Models\Admin;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Models\VendorVehicleRate;
use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = Vehicle::get()->count();
        $users = User::get()->count();
        
        for ($i = 0; $i < 500; $i++) {
            $vehicle = Vehicle::firstWhere('id', mt_rand(1, $vehicles));
            $admins = Admin::where('vendor_id', $vehicle->vendor_id)->pluck('id')->toArray();
            $start = fake()->dateTimeBetween('-5 month', '+1 weeks');
            $end = fake()->dateTimeInInterval($start, '+1 weeks');
            
            $rent = new Rent();
            $rent->rent_number = "RR" . fake()->unique()->randomNumber();
            $rent->vehicle_id = $vehicle->id;
            $rent->user_id = mt_rand(1, $users);
            $rent->location_id = $vehicle->location_id;
            $rent->admin_id = $admins[mt_rand(0, count($admins) - 1)];
            $rent->start_date = $start;
            $rent->end_date = $end;
            $rent->total_price = VendorVehicleRate::where('vendor_id', $vehicle->vendor_id)->where('vehicle_model_id', $vehicle->vehicle_model_id)->first()->daily_rate * (floor((strtotime($end->format('Y-m-d H:i:s')) - strtotime($start->format('Y-m-d H:i:s'))) / 86400)) * 1.1;
            $rent->renter_name = fake()->name();
            $rent->renter_email = fake()->safeEmail();
            $rent->renter_phone = fake()->phoneNumber();
            $rent->driver_name = fake()->name();
            $rent->driver_email = fake()->safeEmail();
            $rent->driver_phone = fake()->phoneNumber();
            $rent->driver_identity = 'storage/upload_KTP/KTP.jpg';
            $rent->driver_license = 'storage/upload_SIM/SIM.jpg';
            $rent->rent_status_id = mt_rand(2, 3);
            $rent->save(); 

            $payment = new Payment();
            $payment->rent_id = $rent->id;
            $payment->payment_method_id = 1;
            $payment->reference_number = fake()->unique()->regexify('REF[A-Z0-9]{10}');
            $payment->card_number = fake()->creditCardNumber();
            $payment->nominal = $rent->total_price;
            $payment->save();
        }
    }
}
