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
                            <a href="" class="btn btn-info btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-edit"></i></a>
                            <a href="" id="delete" class="btn btn-danger btn-sm" style="width:60px; padding:5px; border-radius: 5px;">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="" class="btn btn-warning btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-eye"></i></a>
                            
                            {{-- <a href="{{ route('product.edit', $row->id) }}" class="btn btn-info btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('product.destroy', $row->id) }}" id="delete" class="btn btn-danger btn-sm" style="width:60px; padding:5px; border-radius: 5px;">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="{{ route('product.view', $row->id) }}" class="btn btn-warning btn-sm" style="width:60px; padding:5px; border-radius: 5px;"><i class="fa fa-eye"></i></a>
                            @if($row->status == 1)
                                <a href="{{ route('inactive.product', $row->id) }}" class="btn btn-sm" style="width:60px; padding:5px; border-radius: 5px; border: 2px solid #bbc4c2;"><i class="fa fa-check-circle" style="color: #28a745" title="Inactive"></i></a>
                            @else
                                <a href="{{ route('active.product', $row->id) }}" class="btn btn-sm" style="width:60px; padding:5px; border-radius: 5px; border: 2px solid #bbc4c2;"><i class="fa fa-check-circle" style="color: #EE4B2B;;" title="Active"></i></a>
                            @endif --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection
