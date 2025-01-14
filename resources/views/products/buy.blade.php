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
    </style>

    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            New Product Add
            <a href="{{ route('buyproduct') }}" class="btn btn-success btn-sm pull-right" style="border-radius: 5px;">Sell Product</a>
        </h6>


        <!-- Notification and Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('messege'))
            <div class="alert alert-{{ session('alert-type') }}">
                {{ session('messege') }}
            </div>
        @endif

        <form action="{{ route('store.buyproduct') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-layout">
                <div class="row mg-b-25">
                    <!-- Product Name -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="product_name" class="form-label">Product</label>
                            <input type="text" id="product_name" name="product_name" value="{{ $product->product_name }}" class="form-control" readonly>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                    </div>

                    <!-- Customer Selection -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-control" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Buy Product Quantity: <span class="tx-danger">*</span></label>
                            <input 
                                class="form-control" 
                                type="number" 
                                id="product_qty" 
                                name="product_qty" 
                                min="1" 
                                value="{{ session('updated_stock', $product->product_qty) }}" 
                                placeholder="Enter Buy Product Quantity" 
                                required 
                                oninput="validateQuantity()" 
                                max="{{ session('updated_stock', $product->product_qty) }}">
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            @if(session('stock_message'))
                                <p id="stock-message" class="text-info">
                                    {{ session('stock_message') }}
                                </p>
                            @else
                                <p id="stock-message" class="text-info">
                                    Current stock is {{ $product->product_qty }} units.
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Payment: <span class="tx-danger">*</span></label>
                            <input 
                                class="form-control" 
                                type="number" 
                                name="payment" 
                                id="payment" 
                                placeholder="Enter Payment" 
                                required >
                            <small id="payment-message" class="text-info"></small>
                        </div>
                    </div>

                    
                    <!-- Form Footer -->
                    <div class="form-layout-footer">
                        <button class="btn btn-info mg-r-5">Submit Form</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Required JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>
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
                    } else {
                        // Hide the warning message if due payment exists
                        document.getElementById('warning-message').style.display = 'none';
                        document.getElementById('previous_due').value = data.due_payment;
                        document.getElementById('payment_new').max = data.due_payment; // Ensure max payment is the previous due
                        document.getElementById('payment_new').removeAttribute('disabled');
                    }
    
                    // Show invoice button if due payment is 0
                    if (data.invoice_available) {
                        document.getElementById('invoice-button').style.display = 'block'; // Show invoice button
                    } else {
                        document.getElementById('invoice-button').style.display = 'none'; // Hide invoice button
                    }
                })
                .catch(error => console.log('Error fetching due payment:', error));
        }
    </script>
    
    <!-- Add the invoice button below -->
    <button id="invoice-button" class="btn btn-success" style="display:none;" onclick="generateInvoice()">Generate Invoice</button>
    
    <script>
        function generateInvoice() {
            var productId = document.getElementById('product_id').value;
            var customerId = document.getElementById('customer_id').value;
            window.location.href = `/generate-invoice?product_id=${productId}&customer_id=${customerId}`; // Assuming you have a route to generate the invoice
        }
    </script>
    
    <script>
        // Function to update total price and validate inputs
        function updateTotalPriceAndValidate() {
            const quantityInput = document.getElementById('product_qty');
            const paymentInput = document.getElementById('payment');
            const totalPriceElement = document.getElementById('total-price');
            const quantityMessage = document.getElementById('quantity-message');
            const paymentMessage = document.getElementById('payment-message');
    
            const quantity = parseInt(quantityInput.value) || 0;
            const stock = {{ $product->product_qty }};
            const unitPrice = {{ $product->per_unit_price }};
            const totalPrice = quantity * unitPrice;
    
            // Update total price dynamically
            totalPriceElement.textContent = totalPrice.toFixed(2);
    
            // Validate quantity input
            if (quantity < 1 || quantity > stock) {
                quantityMessage.textContent = `Quantity must be between 1 and ${stock}.`;
                quantityMessage.classList.add('text-danger');
                quantityMessage.classList.remove('text-info');
                quantityInput.setCustomValidity('Invalid quantity.');
            } else {
                quantityMessage.textContent = `Valid quantity. Total price is ${totalPrice.toFixed(2)}.`;
                quantityMessage.classList.remove('text-danger');
                quantityMessage.classList.add('text-info');
                quantityInput.setCustomValidity('');
            }
    
            // Validate payment input based on updated total price
            validatePayment(totalPrice);
        }
    
        // Function to validate payment input
        function validatePayment(totalPrice = parseFloat(document.getElementById('total-price').textContent)) {
            const paymentInput = document.getElementById('payment');
            const paymentMessage = document.getElementById('payment-message');
            const payment = parseFloat(paymentInput.value) || 0;
    
            if (payment < 1 || payment > totalPrice) {
                paymentMessage.textContent = `Payment must be between 1 and ${totalPrice.toFixed(2)}.`;
                paymentMessage.classList.add('text-danger');
                paymentMessage.classList.remove('text-info');
                paymentInput.setCustomValidity('Invalid payment amount.');
            } else {
                paymentMessage.textContent = `Payment is valid within the total price of ${totalPrice.toFixed(2)}.`;
                paymentMessage.classList.remove('text-danger');
                paymentMessage.classList.add('text-info');
                paymentInput.setCustomValidity('');
            }
        }
    
        // Initial setup on page load
        window.onload = function () {
            updateTotalPriceAndValidate();
        };
    </script>
    
    
    <script>
        // Function to update the total price dynamically and display stock message
        function updateTotalPrice() {
            const quantity = parseInt(document.getElementById('product_qty').value) || 0; // Get the entered quantity
            const unitPrice = {{ session('per_unit_price', $product->per_unit_price) }}; // Per unit price
            const stock = {{ session('updated_stock', $product->product_qty) }}; // Get the updated stock
    
            // Calculate the total price
            const totalPrice = quantity * unitPrice;
    
            // Update the total price on the page
            document.getElementById('total-price').textContent = totalPrice.toFixed(2); // Format to 2 decimal places
    
            // Update the stock message
            const stockMessageElement = document.getElementById('stock-message');
            if (quantity > stock) {
                stockMessageElement.textContent = `Insufficient stock! Current stock is ${stock} units.`;
                stockMessageElement.classList.remove('text-info');
                stockMessageElement.classList.add('text-danger');
            } else {
                stockMessageElement.textContent = `Current stock is ${stock} units. Total price for ${quantity} units is ${totalPrice.toFixed(2)}.`;
                stockMessageElement.classList.remove('text-danger');
                stockMessageElement.classList.add('text-info');
            }
        }
    
        // Initial setup when the page loads (set default total price and update it dynamically)
        window.onload = function() {
            updateTotalPrice(); // Set the total price based on the default value of quantity
        };
    </script>
    
    <script>
        // Function to update the total price dynamically based on the product quantity
        function updateTotalPrice() {
            const quantity = parseInt(document.getElementById('product_qty').value); // Get the entered quantity
            const unitPrice = {{ session('per_unit_price', $product->per_unit_price) }}; // Get the per unit price from the session
    
            // Calculate the total price
            const totalPrice = quantity * unitPrice;
    
            // Update the total price on the page
            document.getElementById('total-price').textContent = totalPrice.toFixed(2); // Format the price to 2 decimal places
        }
    
        // Initial setup when the page loads (set default total price and update it dynamically)
        window.onload = function() {
            updateTotalPrice(); // Set the total price based on the default value of quantity
        };
    </script>

    {{-- Summernote Initialization --}}
    <script>
        $(function () {
            $('#summernote').summernote({
                height: 150,
                tooltip: false
            });
        });
    </script>

    {{-- TagsInput Initialization --}}
    <script>
        $(document).ready(function () {
            $('#size').tagsinput();
        });
    </script>
@endsection
