@extends('user.layouts.main')

<style>
    .payment-info {
        /* background-color: #eee; */
        border: 2px solid #888 !important;
        border-radius: 10pt !important;
    }

    table {
        table-layout: fixed;
    }

    table td {
        padding: 15px 7px !important;
    }

    /* thead tr th {
        color: #ddd !important;
    }

    tbody tr td {
        color: #888 !important;
    } */
</style>

@section('container')
    <div class="container p-4">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8 p-5 tile">
                <div class="row">
                    <div class="hstack gap-3">
                        <div>
                            <img src="/storage/website-assets/invoice.png" alt="Invoice" width="50px">
                        </div>
                        <div class="vstack">
                            <h5 class="fw-semibold">Invoice for {{ $payment->rent->rent_number }}</h5>
                            <p class="text-muted mb-0">Issued at {{ $payment->created_at }}</p>
                        </div>
                    </div>
    
                    <hr class="my-3 mb-4">
                    <div class="col-6">
                        <p class="fw-semibold mb-1">From:</p>
                        <p class="text-muted">
                            Rentcars.id
                            <br>
                            Jl. Imam Bonjol 123, Surabaya
                            <br>
                            +62812345678
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="fw-semibold mb-1">To:</p>
                        <p class="text-muted">
                            {{ $payment->rent->renter_name }}
                            <br>
                            {{ $payment->rent->renter_phone }}
                        </p>
                    </div>

                    <div class="payment-info col my-3 p-4">
                        <div class="row mb-3">
                            <div class="col text-muted">Reference Number</div>
                            <div class="col fw-semibold text-end">
                                {{ $payment->reference_number }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-muted">Payment Method</div>
                            <div class="col fw-semibold text-end">
                                {{ $payment->paymentMethod->method }}
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-4 p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:40%" class="text-light">Item</th>
                                    <th class="text-light">Daily Rate</th>
                                    <th class="text-light">Dur</th>
                                    <th class="text-light">Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-secondary">
                                <tr>
                                    <td style="width:40%">
                                        {{ $payment->rent->vehicle->vehicleModel->brand . ' ' . $payment->rent->vehicle->vehicleModel->model }}
                                    </td>
                                    <td>
                                        Rp {{ number_format($payment->rent->vehicle->vehicleModel->daily_rate, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        {{-- {{ dd($payment->rent) }} --}}
                                        {{ floor((strtotime($payment->rent->end_date) - strtotime($payment->rent->start_date)) / 86400) == 1 ?
                                            floor((strtotime($payment->rent->end_date) - strtotime($payment->rent->start_date)) / 86400) . ' day' :
                                            floor((strtotime($payment->rent->end_date) - strtotime($payment->rent->start_date)) / 86400) . ' days' }}
                                    </td>
                                    <td>
                                        Rp {{ 
                                            number_format($payment->rent->vehicle->vehicleModel->daily_rate * 
                                            (date_diff(new Datetime($payment->rent->end_date), new Datetime($payment->rent->start_date))->d + 1)
                                            , 0, ',', '.') 
                                        }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:40%">Tax 10%</td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        Rp {{ number_format($payment->rent->vehicle->vehicleModel->daily_rate 
                                            * (date_diff(new Datetime($payment->rent->end_date), new Datetime($payment->rent->start_date))->d + 1) * 0.1
                                            , 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="text-light">
                                    <td colspan='3' class="fw-semibold">Total Price</td>
                                    <td class="fw-semibold fs-5">Rp {{ number_format($payment->rent->total_price, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection