@extends('layouts.app')
@section('content')
    <!-- Required CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">
    <link href="{{ asset('backend/lib/summernote/summernote-bs4.css') }}" rel="stylesheet">

        <div class="card pd-20 pd-sm-40">
            <h6 class="card-body-title"><a href="{{ route('products.index') }}" class="btn btn-success btn-sm pull-right">All Product</a></h6>
            <h5 class="mg-b-20 mg-sm-b-30">Product Details</h5>      
            <div class="form-layout">
                <div class="row mg-b-25">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Product Name: <span class="tx-danger">*</span></label>
                            <br>
                            <strong>{{ $product->product_name }}</strong>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Image One (Main Thumbnail) <span class="tx-danger">*</span></label>
                        <div class="file-container">
                            <label class="custom-file">
                                
                            </label>
                            <img src="{{ URL::to($product->product_img) }}" id="one" style="height: 80px; width:100px;">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Product Quantity: <span class="tx-danger">*</span></label>
                            <br>
                            <strong>{{ $product->product_qty }}</strong>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Quantity: <span class="tx-danger">*</span></label>
                            <br>
                            <strong>{{ $product->sell_qty }}</strong>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mg-b-10-force">
                          <label class="form-control-label">Per Unit Price <span class="tx-danger">*</span></label>
                            <br>
                            <strong>{{ $product->per_unit_price }}</strong>
                        </div>
                      </div>

                </div>
        </div><!-- card -->

@endsection
