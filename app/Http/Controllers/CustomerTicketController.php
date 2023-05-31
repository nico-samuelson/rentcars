<?php

namespace App\Http\Controllers;

use App\Models\CustomerTicket;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email:dns',
            'message' => 'required'
        ]); 
        
        // dd($validator->valid());
        if ($validator->fails()) {
            session()->put('ticket-submission-success', false);
            return redirect('/')->withInput()->withErrors($validator);
        }

        $admins = Staff::where('position', 'Staff')->where('department_id', 4)->get();
        $adminId = mt_rand(0, $admins->count()-1);
        $admin = $admins->slice($adminId, 1)->toArray();
        
        $data = $validator->valid();
        $data['resolved'] = false;
        $data['admin_id'] = $admin[$adminId]['id'];

        CustomerTicket::create($data);
        // session()->put('ticket-submission-success', true);
        // dd(session()->all());
        session()->put('ticket-submission-success', true);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerTicket $customerTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerTicket $customerTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerTicket $customerTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerTicket  $customerTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerTicket $customerTicket)
    {
        //
    }
}
