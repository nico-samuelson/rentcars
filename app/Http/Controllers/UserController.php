<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use App\Models\Rent;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    protected $rent;

    public function __construct()
    {
        $this->rent = new Rent;
    }

    public function show() {
        return view('user.profile', [
            'title' => 'My Profile',
            'locations' => Location::all(),
        ]);
    }

    public function edit(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => ['required', 'email:dns', Rule::unique('users')->ignore(auth()->user()->id),],
            'birth_date' => 'required|date|before:today',
            'phone' => 'numeric|min:8',
            'city' => 'max:255',
        ]); 
        
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        }
        
        $data = $validator->valid();

        $user = User::firstWhere('id', auth()->user()->id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->birth_date = $data['birth_date'];
        $user->phone = $data['phone'];
        $user->city = $data['city'];
 
        return $user->save() ? 1 : 0;
    }

    public function changePass(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|max:255',
            'newPass' => 'min:8',
            'newPassConfirmed' => 'same:newPass',
        ]); 
        
        if ($validator->fails()) {
            return redirect()->back()->with('changePassFailed', 'Failed to change password, please try again later');
        }
        
        $data = $validator->valid();
        $user = User::firstWhere('id', auth()->user()->id);
        
        // Match password
        if (!Hash::check($data['password'], auth()->user()->password)) {
            return redirect()->back()->with('invalidPass', 'Wrong password!');
        }
        
        // Check when user last changed their password
        if (!auth()->user()->last_password_changed || 
        date_diff(Carbon::now(), date_create(auth()->user()->last_password_changed))->h >= 72) {

            // Change the password
            $user->last_password_changed = Carbon::now();
            $user->password = bcrypt($data['newPass']);
            
            // Logout user after successfull password change
            if ($user->save()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route("login")->with('passwordChanged', 'Password changed successfully!');
            }

            // Failed password changes
            return redirect()->back()->with('changePassFailed', 'Failed to change password, please try again later');
        }

        // If user change their password before 72 hours after last change
        if (date_diff(Carbon::now(), date_create(auth()->user()->last_password_changed))->h < 72) {
            return back()->with('changeRestricted', 'You can only change your password once every 72 hours!');
        }
    }

    public function deleteAccount() {
        $ongoingRent = $this->rent->getOngoingRent();

        // Check if user still have ongoing order
        if ($ongoingRent->count() > 0)
            return back()->with('ongoingRent', "Uh oh, looks like you still have some uncompleted orders!");

        // Delete account
        if (User::where('id', auth()->user()->id)->delete()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
            return redirect()->route("login")->with('accountDeleted', 'Your account has been deleted!');
        }

        return back()->with('errorDelete', 'Error deleting your account! Please try again later');
    }

    public function showBookings() {
        return view('user.bookings', [
            'title' => 'My Bookings',
            'rents' => $this->rent->getRentByStatus([2, 3, 4]),
        ]);
    }

    public function filterBookings(Request $request) {
        if ($request->bookingStatus == 'Unpaid')
            $rents = $this->rent->getRentByStatus([1]);

        else if ($request->bookingStatus == 'Ongoing')
            $rents = $this->rent->getRentByStatus([2, 3, 4]);

        else if ($request->bookingStatus == 'Rejected')
            $rents = $this->rent->getRentByStatus([5]);

        else if ($request->bookingStatus == 'Completed')
            $rents = $this->rent->getRentByStatus([6,7,8]);

        return view('user.partials.booking', [
            'rents' => $rents
        ]);
    }

    public function bookingDetail($rent_number) {
        $rent = Rent::where('user_id', auth()->user()->id)->where('rent_number', $rent_number)->get()->first();
        $payment = Payment::firstWhere('rent_id', $rent->id);

        if ($rent->count() > 0 && $payment)
            return view('user.booking', [
                'title' => 'Rent Detail',
                'rent' => $rent,
            ]);

        else if (!$payment)
            return redirect()->route('rent-payment', ['rent_number' => $rent_number]);
        
        abort(403);
    }
}