@extends('layouts.app')

@section('content')
    <!-- Required CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">
    <link href="{{ asset('backend/lib/summernote/summernote-bs4.css') }}" rel="stylesheet">

    <style>
        .file-container {
            display: flex;
            align-items: center;
        }

        .custom-file {
            flex-grow: 1;
        }

        .image_preview {
            display: none;
            margin-left: 10px;
            max-width: 100px;
            max-height: 80px;
        }

        #due-payment-section {
            display: none;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .invoice-button {
            display: none;
            margin-top: 20px;
        }
    </style>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h4 class="card-title text-center">Process Due Payment</h4>

                <!-- Notification and Error Messages -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div id="warning-message" class="alert alert-warning" style="display: none;">
                    No due payment found for the selected product and customer.
                </div>

                <form action="{{ route('process.payment') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="product_id">Select Product:</label>
                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="customer_id">Select Customer:</label>
                            <select name="customer_id" id="customer_id" class="form-control" required>
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="previous_due">Previous Due Payment:</label>
                        <input type="text" name="previous_due" id="previous_due" class="form-control" readonly value="{{ old('previous_due') }}">
                    </div>

                    <div class="form-group">
                        <label for="payment_new">Enter New Payment:</label>
                        <input type="number" name="payment_new" id="payment_new" class="form-control" min="1" max="{{ old('previous_due') }}" required>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Process Payment</button>
                    </div>
                </form>

                <!-- Invoice Button -->
                <div id="invoice-button" class="invoice-button text-center">
                    <a href="#" class="btn btn-success btn-lg" id="generate-invoice">Generate Invoice</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Required JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>

    {{-- AJAX to get due payment dynamically --}}
    <script>
        document.getElementById('product_id').addEventListener('change', function() {
            var productId = this.value;
            var customerId = document.getElementById('customer_id').value;
            if (productId && customerId) {
                fetchDuePayment(productId, customerId);
            }
        });

        document.getElementById('customer_id').addEventListener('change', function() {
            var customerId = this.value;
            var productId = document.getElementById('product_id').value;
            if (productId && customerId) {
                fetchDuePayment(productId, customerId);
            }
        });

        function fetchDuePayment(productId, customerId) {
            fetch(`/get-due-payment?product_id=${productId}&customer_id=${customerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.due_payment === 0 || data.due_payment === null) {
                        // Show the warning message if no due payment exists
                        document.getElementById('warning-message').style.display = 'block';
                        document.getElementById('previous_due').value = '';
                        document.getElementById('payment_new').value = '';
                        document.getElementById('payment_new').setAttribute('disabled', 'true');
                        document.getElementById('invoice-button').style.display = 'none'; // Hide invoice button
                    } else {
                        // Hide the warning message if due payment exists
                        document.getElementById('warning-message').style.display = 'none';
                        document.getElementById('previous_due').value = data.due_payment;
                        document.getElementById('payment_new').max = data.due_payment; // Ensure max payment is the previous due
                        document.getElementById('payment_new').removeAttribute('disabled');

                        // Show invoice button if due payment is 0.00
                        if (data.due_payment === 0) {
                            document.getElementById('invoice-button').style.display = 'block'; // Show invoice button
                        } else {
                            document.getElementById('invoice-button').style.display = 'none'; // Hide invoice button
                        }
                    }
                })
                .catch(error => console.log('Error fetching due payment:', error));
        }

        // Generate invoice when the button is clicked
        document.getElementById('generate-invoice').addEventListener('click', function(e) {
            e.preventDefault();

            var productId = document.getElementById('product_id').value;
            var customerId = document.getElementById('customer_id').value;

            // Redirect to the route that generates the invoice (adjust route as needed)
            window.location.href = `/generate-invoice?product_id=${productId}&customer_id=${customerId}`;
        });
    </script>
@endsection