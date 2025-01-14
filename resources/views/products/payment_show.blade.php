@extends('layouts.app')

@section('content')
    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            Payment Details
            <!-- Invoice Print Button -->
            @can('payment')
                <a href="{{ route('payment.index') }}" class="btn btn-danger btn-sm" style="margin-left:5px; border-radius: 5px; float: right;">Payment</a>
            @endcan
            <button id="printInvoice" class="btn btn-primary btn-sm" style="margin-left:5px; border-radius: 5px; float: right;">Print Invoice</button>
        </h6>
        <div class="table-wrapper">
            <table id="invoice-table" class="table display responsive nowrap">
                <thead>
                    <tr>
                        <th class="wd-10p">Customer Name</th>
                        <th class="wd-10p">Product Name</th>
                        <th class="wd-10p">Due Payment</th>
                        <th class="wd-10p">New Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->customer_name }}</td>
                        <td>{{ $payment->product_name }}</td>
                        <td>{{ $payment->due_payment }}</td>
                        <td>{{ $payment->new_payment }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include jsPDF and autoTable library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize jsPDF
            const { jsPDF } = window.jspdf;

            // Get the button and table
            const printButton = document.getElementById('printInvoice');
            const table = document.getElementById('invoice-table');

            // Add event listener to the button
            printButton.addEventListener('click', function() {
                const doc = new jsPDF();
                
                // Generate the table as a PDF
                doc.autoTable({ html: '#invoice-table' });

                // Save the PDF
                doc.save('invoice.pdf');
            });
        });
    </script>
@endsection
