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
                            <label class="form-control-label">Total Price: </label>
                            <p id="total-price">
                                {{ session('total_price', 0) }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Payment: <span class="tx-danger">*</span></label>
                            <!-- Display the calculated total price as the placeholder -->
                            <input 
                                class="form-control" 
                                type="number" 
                                name="payment" 
                                id="payment" 
                                placeholder="Enter Payment" 
                                required 
                                min="0" 
                                value="{{ old('payment', session('payment')) }}">
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
