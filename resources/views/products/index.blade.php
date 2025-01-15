@extends('layouts.app')

@section('content')

    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            Product List
            @can('product-list')
            <a href="{{ route('product.add') }}" class="btn btn-warning btn-sm" style="border-radius: 8px; float: right;">Add Product</a>
            @endcan
        </h6>
        <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                    <tr>
                        <th class="wd-15p">Product ID</th>
                        <th class="wd-15p">Product Name</th>
                        <th class="wd-15p">Image</th>
                        <th class="wd-10p">Total Product Quantity</th>
                        {{-- <th class="wd-10p">Availavle Product Quantity</th>  --}}
                        <th class="wd-10p">Per Unit Price</th>
                        {{-- <th class="wd-10p">Total Price</th> --}}
                        <th class="wd-25p">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php($serial = 1)
                    @foreach($product as $row)
                    <tr>
                        <td>{{$serial++}}</td>
                        <td>{{ $row->product_name }}</td>
                        <td><img src="{{ URL::to($row->product_img) }}" alt="brand img" height="60px;" width="80px;"></td>
                        <td>{{ $row->total_qty }}</td>
                        {{-- <td>{{ $row->product_qty }}</td> --}}
                        <td>{{ $row->per_unit_price }} ৳</td>
                        {{-- <td>{{ number_format($row->product_qty * $row->per_unit_price, 2) }} taka</td> --}}
                        
                        <td>
                            @can('product-edit')
                            <a href="{{ route('product.edit', $row->id) }}" class="btn btn-info btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-edit"></i></a>
                            @endcan

                            @can('product-show')
                            <a href="{{ route('products.show', $row->id) }}" class="btn btn-warning btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-eye"></i></a>
                            @endcan

                            @can('product-destroy')
                            <a href="{{ route('product.destroy', $row->id) }}" id="delete" class="btn btn-danger btn-sm" style="width:60px; padding:5px; border-radius: 5px;">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endcan

                            @can('buy-product-create-list')
                            <a href="{{ route('buy.product', $row->id) }}" class="btn btn-primary btn-sm" style="width:60px; padding:5px; border-radius: 5px;">
                                <i class="ri-arrow-right-line"></i>
                                <span> Buy </span>
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
