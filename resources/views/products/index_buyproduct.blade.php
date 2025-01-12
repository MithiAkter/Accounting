@extends('layouts.app')

@section('content')

    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            Product List<a href="{{ route('products.index') }}" class="btn btn-warning" style="float: right;">All Product</a>
        </h6>
        <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                    <tr>
                        <th class="wd-15p">Product ID</th>
                        <th class="wd-15p">Product Name</th>
                        <th class="wd-15p">Customer Name</th>
                        <th class="wd-15p">Product Quantity</th>
                        <th class="wd-15p">Per Unit Price</th>
                        <th class="wd-15p">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buyproducts as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->per_unit_price }}</td>
                        <td>{{ $row->product_qty }}</td>
                        <td>{{ number_format($row->per_unit_price * $row->product_qty, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection
