
@extends('backend.layouts-new.app')

@section('content')

<style>
  .form-check-label {
      text-transform: capitalize;
  }
  .select2{
    width: 100%!important
  }
  label{
    float: left;
  }
</style>

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Users List</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                            {{-- <a class="btn btn-primary text-white" style="float: right" href="{{ route('admin.admins.create') }}" data-bs-toggle="modal" data-bs-target="#exampleModal"> --}}
                            <a class="btn btn-primary text-white mb-2" style="float: right" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                Create</a>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.admins.store') }}" method="POST">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="email">Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                                                </div>
                                            </div>
                    
                                            <div class="form-row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                                </div>
                                            </div>
                    
                                            <div class="form-row">
                                                <div class="form-group col-md-12 col-sm-6">
                                                    <label for="password">Cabang</label>
                                                    <select name="id_cabang" id="cabang" class="form-control">
                                                        <option value="" disabled selected>Pilih Cabang</option>
                                                        @foreach ($cabang as $cb)
                                                            <option value="{{ $cb->id }}"  >{{ $cb->cabang }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="password">Assign Roles</label>
                                                    <select name="roles[]" id="roles" class="form-control"  required>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 col-sm-12">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                                                </div>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" style="float: right">Save</button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Cabang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($admins as $admin)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach ($admin->roles as $role)
                                            <span class="badge bg-info mr-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $admin->cabang->cabang ?? '-' }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $admin->id }}" href="#">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modalEdit{{ $admin->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 col-sm-12">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $admin->name }}">
                                                                </div>
                                                                <div class="form-group col-md-12 col-sm-12">
                                                                    <label for="email">Email</label>
                                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $admin->email }}">
                                                                </div>
                                                            </div>
                                    
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 col-sm-12">
                                                                    <label for="password">Password</label>
                                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                                                </div>
                                                                <div class="form-group col-md-12 col-sm-12">
                                                                    <label for="password_confirmation">Confirm Password</label>
                                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Password">
                                                                </div>
                                                            </div>
                                    
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 col-sm-6">
                                                                    <label for="password">Cabang</label>
                                                                    <select name="id_cabang" id="cabang" class="form-control">
                                                                        <option value="" disabled selected>Pilih Cabang</option>
                                                                        @foreach ($cabang as $cb)
                                                                            <option value="{{ $cb->id }}" {{ $admin->id_cabang == $cb->id ? 'selected' : '' }} >{{ $cb->cabang }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 col-sm-6">
                                                                    <label for="username">Username</label>
                                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $admin->username }}">
                                                                </div>
                                                            </div>
                                    
                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 col-sm-6">
                                                                    <label for="password">Assign Roles</label>
                                                                    <select name="roles[]" id="roles" class="form-control">
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-12 col-sm-6">
                                                                    <label for="username">Username</label>
                                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $admin->username }}">
                                                                </div>
                                                            </div>
                                    
                                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4" style="float: right">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if (Auth::guard('admin')->user()->can('admin.delete'))
                                        <a class="btn btn-danger text-white" href="{{ route('admin.admins.destroy', $admin->id) }}"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $admin->id }}').submit();">
                                        <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>

@endsection


@section('script')
   
@endsection