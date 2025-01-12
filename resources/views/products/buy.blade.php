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
            <a href="{{ route('products.index') }}" class="btn btn-success btn-sm pull-right">All Product</a>
        </h6>

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
                                name="product_qty" 
                                max="{{ $product->product_qty - $product->sell_qty }}" 
                                placeholder="Enter Buy Product Quantity" required>
                            <small class="text-muted">
                                Product Exist: {{ $product->product_qty - $product->sell_qty }}
                            </small>
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

    {{-- Summernote Initialization --}}
    <script>
        $(function () {
            $('#summernote').summernote({
                height: 150,
                tooltip: false
            });
        });
    </script>

    {{-- AJAX for Subcategory --}}
    <script>
        $(document).ready(function () {
            $('select[name="category_id"]').on('change', function () {
                const categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ url('/get/subcategory/') }}/" + categoryId,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            const subcategorySelect = $('select[name="subcategory_id"]');
                            subcategorySelect.empty();
                            $.each(data, function (key, value) {
                                subcategorySelect.append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                            });
                        },
                    });
                } else {
                    alert('Please select a valid category.');
                }
            });
        });
    </script>

    {{-- Image Preview --}}
    <script>
        function readURL(input, target) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $(target).attr('src', e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $(target).hide();
            }
        }
    </script>

    <script>
        $('#image_input').on('change', function () {
            readURL(this, '#one');
        });
        $('#image_input_2').on('change', function () {
            readURL(this, '#two');
        });
        $('#image_input_3').on('change', function () {
            readURL(this, '#three');
        });
    </script>

    {{-- TagsInput Initialization --}}
    <script>
        $(document).ready(function () {
            $('#size').tagsinput();
        });
    </script>
@endsection
