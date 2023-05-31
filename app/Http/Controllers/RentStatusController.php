<?php

namespace App\Http\Controllers;

use App\Models\RentStatus;
use App\Http\Requests\StoreRentStatusRequest;
use App\Http\Requests\UpdateRentStatusRequest;

class RentStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreRentStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRentStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentStatus  $rentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(RentStatus $rentStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RentStatus  $rentStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(RentStatus $rentStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRentStatusRequest  $request
     * @param  \App\Models\RentStatus  $rentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRentStatusRequest $request, RentStatus $rentStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RentStatus  $rentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(RentStatus $rentStatus)
    {
        //
    }
}
