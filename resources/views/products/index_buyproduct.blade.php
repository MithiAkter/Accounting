@extends('layouts.app')

@section('content')
<style>
    .disabled-button {
        background-color: #ccc !important;
        border-color: #ccc !important;
        color: #fff !important;
        pointer-events: none; /* Ensures the button is not clickable */
    }
</style>

    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            Product List
            @can('product-show')
            <a href="{{ route('products.index') }}" class="btn btn-warning" style="float: right;">All Product</a>
            @endcan
        </h6>
        <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
                @php($serial = 1)
                <thead>
                    <tr>
                        <th class="wd-10p">Product ID</th>
                        <th class="wd-10p">Product Name</th>
                        <th class="wd-10p">Customer Name</th>
                        <th class="wd-10p">Product Quantity</th>
                        <th class="wd-10p">Per Unit Price</th>
                        <th class="wd-10p">Total Price</th>
                        <th class="wd-10p">Payment</th>
                        <th class="wd-10p">Due</th>
                        <th class="wd-10p">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($buyproducts as $row)
                    <tr>
                        <td>{{$serial++}}</td>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->product_qty }}</td>
                        <td>{{ $row->per_unit_price }}</td>
                        <td>{{ number_format($row->per_unit_price * $row->product_qty, 2) }}</td>
                        <td>{{ $row->payment }}</td>
                        <td>{{ number_format($row->per_unit_price * $row->product_qty - $row->payment, 2) }}</td> 
                        <td>
                            @can('invoice')
                            <a href="" class="btn btn-info btn-sm" style="border-radius: 5px;">Invoice
                            @endcan
                            @can('payment')
                            <a href="{{ route('payment') }}" class="btn btn-danger btn-sm" style="margin-left:5px; border-radius: 5px;">Payment
                            @endcan

                            </a>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    


@endsection
