@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Users Management</h2>
        </div>
        <div class="pull-right">
            @can('user-create')
            <a class="btn btn-sm btn-success mb-2" style="border-radius: 8px;" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New User</a>
            @endcan
        </div>
    </div>
</div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<table class="table table-bordered">
   <tr>
       <th>No</th>
       <th>Name</th>
       <th>Email</th>
       <th>Roles</th>
       <th width="280px">Action</th>
   </tr>
   @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
               <label class="badge bg-success">{{ $v }}</label>
            @endforeach
          @endif
        </td>
        <td>
            @can('user-show')
             <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}" style="border-radius: 5px;">Show</a>
            @endcan
            @can('user-edit')
             <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}" style="border-radius: 5px;">Edit</a>
            @endcan
              <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                  @csrf
                  @method('DELETE')
                @can('user-delete')
                  <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 5px;">Delete</button>
                @endcan
              </form>
        </td>
    </tr>
 @endforeach
</table>

{!! $data->links('pagination::bootstrap-5') !!}


@endsection
