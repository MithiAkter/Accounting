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
            <h6 class="card-body-title">New Product Add <a href="{{ route('products.index') }}" class="btn btn-success btn-sm pull-right">All Product</a></h6>
            <form action="{{ route('store.product') }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="form-layout">
                <div class="row mg-b-25">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Product Name: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="product_name">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Product Image<span class="tx-danger">*</span></label>
                        <div class="file-container mb-3">
                            <label class="custom-file">
                                <input type="file" id="file" class="custom-file-input" name="product_img" onchange="readURL(this);">
                                <span class="custom-file-control"></span>
                            </label>
                            <img src="#" id="one" class="image_preview">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Product Quantity: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="product_qty">
                        </div>
                    </div>
                    {{-- <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Sell Quantity: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="sell_qty">
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Per Unit Price: <span class="tx-danger">*</span></label>
                            <input class="form-control" type="text" name="per_unit_price">
                        </div>
                    </div>


                <!-- Form Footer -->
                <div class="form-layout-footer">
                    <button class="btn btn-info mg-r-5">Submit Form</button>
                    <button class="btn btn-secondary">Cancel</button>
                </div><!-- form-layout-footer -->
            </div><!-- form-layout -->
        </form>
        </div><!-- card -->


    <!-- Required JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>
    
        {{-- summernote --}}
        <script>
            $(function(){
              'use strict';
      
              //Inline editor
              var editor = new MediumEditor('.editable');
      
              $('#summernote').summernote({
                height: 150,
                tooltip: false
                })
              });
              </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function() {
                var category_id = $(this).val();
                if(category_id) {
                    
                    $.ajax({
                        url: "{{  url('/get/subcategory/') }}/"+category_id,
                        type:"GET",
                        dataType:"json",
                        success:function(data) {
                            var d =$('select[name="subcategory_id"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="subcategory_id"]').append('<option value="'+ value.id +'">' 
                                    + value.subcategory_name + '</option>');
                            });
                        },
                    });
                } else {
                    alert('danger');
                }
            });
        });
        </script>
        <script type="text/javascript">
           function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#one')
                .attr('src', e.target.result)  // Set the image source
                .show(); // Show the image after selection
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#one').hide(); // Hide the preview if no file is selected
    }
}
            
        </script>
        <script type="text/javascript">
            function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#two')
                .attr('src', e.target.result)
                .show();
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#two').hide();
    }
}
        </script>
        <script type="text/javascript">
            function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#three')
                .attr('src', e.target.result)
                .show();
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#three').hide();
    }
}
        </script>



    <!-- TagsInput Initialization -->
    <script>
        $(document).ready(function () {
            console.log('TagsInput Plugin:', $('#size').tagsinput); 
            $('#size').tagsinput();
        });
    </script>
@endsection
