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
            Due payment
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

        <form action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-layout">
                    
                    <!-- Payment Section -->
                    
                        <div class="form-group">
                           
                            <input 
                                class="form-control" 
                                type="number" 
                                name="payment_new" 
                                id="payment_new" 
                                placeholder="Enter Payment" 
                                required>
                        </div>
                    
                    

                    <!-- Form Footer -->
                    <div class="form-layout-footer">
                        <button class="btn btn-info mg-r-5">Submit Form</button>
                    </div>
            </div>
        </form>
    </div>

    <!-- Required JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>




    {{-- TagsInput Initialization --}}
    <script>
        $(document).ready(function () {
            $('#size').tagsinput();
        });
    </script>
@endsection
