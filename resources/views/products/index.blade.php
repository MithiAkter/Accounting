@extends('layouts.app')

@section('content')

    <div class="card pd-20 pd-sm-40">
        <h6 class="card-body-title">
            Product List
            
            <a href="{{ route('product.add') }}" class="btn btn-warning" style="float: right;">Add Product</a>
        </h6>
        <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
                <thead>
                    <tr>
                        
                        <th class="wd-15p">Product ID</th>
                        <th class="wd-15p">Product Name</th>
                        <th class="wd-15p">Image</th>
                        <th class="wd-10p">Quantity</th>
                        <th class="wd-10p">Sell Quantity</th>
                        <th class="wd-10p">Per Unit Price</th>
                        <th class="wd-25p">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->product_name }}</td>
                        <td><img src="{{ URL::to($row->product_img) }}" alt="brand img" height="60px;" width="80px;"></td>
                        <td>{{ $row->product_qty }}</td>
                        <td>{{ $row->sell_qty }}</td>
                        <td>{{ $row->per_unit_price }} taka</td>
                        <td>
                            <a href="{{ route('product.edit', $row->id) }}" class="btn btn-info btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('products.show', $row->id) }}" class="btn btn-warning btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('product.destroy', $row->id) }}" id="delete" class="btn btn-danger btn-sm" style="width:60px; padding:5px; border-radius: 5px;">
                                <i class="fa fa-trash"></i>
                            </a>
                            {{-- <a href="{{ route('buy.product') }}" class="btn btn-primary btn-sm" style="width:60px; padding:5px; border-radius: 5px;">Buy</a> --}}
                            {{-- @can('buy-product-list') --}}
                            <a href="{{ route('buy.product', $row->id) }}" class="btn btn-primary btn-sm" style="width:60px; padding:5px; border-radius: 5px;">
                                <i class="ri-arrow-right-line"></i>
                                <span> Buy </span>
                            </a>
                            {{-- @endcan --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection
