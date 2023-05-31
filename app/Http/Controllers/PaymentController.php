<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardVerificationRequest;
use App\Models\Payment;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentController extends Controller
{
    protected $payment;

    public function __construct()
    {
        $this->payment = new Payment();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('payment.iindex')
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $rent_number)
    {
        $validatedUser = Rent::where('rent_number', $rent_number)->where('user_id', auth()->user()->id)->get()->count();
        // dd(auth()->user()->id);



        if ($validatedUser && $this->payment->getPaymentInfo($rent_number)->count() == 0) {
            return view('user.payment.create', [
                'title' => 'Payment',
                'rent' => Rent::firstWhere('rent_number', $rent_number),
            ]);
        }

        if ($this->payment->getPaymentInfo($rent_number)->count() > 0) {
            return view('user.payment.show', [
                'title' => 'Payment Detail',
                'payment' => $this->payment->getPaymentInfo($rent_number)[0],
            ]);
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardVerificationRequest $request, $rent_number)
    {
        $validatedPayment = $request->validated();
        $rent = Rent::firstWhere('rent_number', $rent_number);

        $validatedPayment['rent_id'] = $rent->id;
        $validatedPayment['payment_method_id'] = 1;
        $validatedPayment['reference_number'] = fake()->unique()->regexify('REF[A-Z0-9]{10}');
        $validatedPayment['nominal'] = $rent->total_price;
        unset($validatedPayment['cvc'], $validatedPayment['expiration_month'], $validatedPayment['expiration_year']);
        
        DB::beginTransaction();
        try {
            // Insert payment
            Payment::create($validatedPayment);
            // Update rent status
            Rent::where('rent_number', $rent_number)->update(['status_id' => 2]);

            // Commit changes
            DB::commit();

            return redirect()->route('payment.show', ['payment' => $validatedPayment['reference_number']]);
        }
        catch(Exception $e) {
            // Rollback changes
            DB::rollback();

            return redirect()->back()->with('Error', 'Terjadi kesalahan dalam menginput data, silahkan mencoba lagi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function showInvoice($reference_number)
    {
        $payment = Payment::firstWhere("reference_number", $reference_number);
 
        if ($payment->rent->user_id == auth()->user()->id) {
            return view('user.payment.invoice', [
                'title' => 'Invoice',
                'payment' => $payment, 
            ]);
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
