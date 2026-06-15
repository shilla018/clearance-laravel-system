@extends('layouts.clearanceDashboardLayout')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4 dashboard-page sims-page">
    <section class="sims-panel">
        <div class="sims-panel__header">
            <h3>Student Invoice List</h3>
        </div>
        <div class="sims-panel__body">
            <p class="sims-warning-text mb-2">
                NOTE : PLEASE USE CONTROL NUMBER TO MAKE PAYMENT
            </p>

            @foreach ($paymentYears as $paymentYear)
                <section class="sims-invoice-block">
                    <h4>Invoice for Academic Year : {{ $paymentYear['year'] }}</h4>
                    <div class="table-responsive">
                        <table class="table sims-table align-middle">
                            <thead>
                                <tr>
                                    <th>S/No</th>
                                    <th>Pick</th>
                                    <th>InvoiceNo</th>
                                    <th>Control Number</th>
                                    <th>Description</th>
                                    <th>Payment Mode</th>
                                    <th>Currency</th>
                                    <th class="text-end">Invoice Amount</th>
                                    <th class="text-end">Paid Amount</th>
                                    <th class="text-end">Balance</th>
                                    <th>Statement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentYear['invoices'] as $invoice)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><input class="form-check-input sims-checkbox" type="checkbox" checked></td>
                                        <td><a href="#" class="sims-link">{{ $invoice['invoice_no'] }}</a></td>
                                        <td>{{ $invoice['control_number'] }}</td>
                                        <td>{{ $invoice['description'] }}</td>
                                        <td>{{ $invoice['mode'] }}</td>
                                        <td>{{ $invoice['currency'] }}</td>
                                        <td class="text-end">{{ $invoice['amount'] }}</td>
                                        <td class="text-end">{{ $invoice['paid'] }}</td>
                                        <td class="text-end {{ $invoice['balance'] !== '0.00' ? 'sims-balance-due' : '' }}">{{ $invoice['balance'] }}</td>
                                        <td><a href="#" class="sims-link"><i class="bi bi-eye"></i> View</a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="11">
                                        <button class="sims-print-link" type="button">Print selected Invoices</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            @endforeach

            <p class="sims-warning-text mt-4">
                IMPORTANT : MAKE SURE YOU PAY ADMINISTRATIVE FEE FIRST BEFORE TUITION FEE.
            </p>

            <section class="sims-payment-methods">
                <h4>Payment Method/Channel</h4>
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="sims-method-title">Airtel Money</div>
                        <ol>
                            <li>Dial *150*01#</li>
                            <li>Choose Option 4 --- "Pay Bills"</li>
                            <li>Choose Option 5 --- "Government Payment"</li>
                            <li>Enter Reference Number -- <strong>Control Number</strong></li>
                            <li>Enter Amount</li>
                            <li>Enter pin to confirm</li>
                        </ol>
                    </div>
                    <div class="col-lg-6">
                        <div class="sims-method-title">M-Pesa</div>
                        <ol>
                            <li>Dial *150*00#</li>
                            <li>Choose Option 4 --- "Pay by M-Pesa"</li>
                            <li>Choose Option 5 --- "Government Payment"</li>
                            <li>Enter Reference Number -- <strong>Control Number</strong></li>
                            <li>Enter your pin</li>
                            <li>Confirm payment</li>
                        </ol>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endpush
