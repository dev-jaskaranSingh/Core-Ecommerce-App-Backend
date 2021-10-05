@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Create Employee</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create Employee</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Create Employee</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{route('employee-update',$employee->id)}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <lable>Name*</lable>
                                        <div class="form-group" @error('name') has-error @enderror">
                                        <input class="form-control" type="text" name="name" value="{{$employee->name}}"/>
                                        @error('name')
                                        <span class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <lable>Mobile*</lable>
                                    <div class="form-group" @error('mobile') has-error @enderror">
                                    <input class="form-control" type="text" name="mobile" value="{{$employee->mobile}}"/>
                                    @error('mobile')
                                    <span class="text-danger" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="col-md-6">
                            <lable>New Password*</lable>
                            <div class="form-group" @error('password') has-error @enderror">
                            <input class="form-control" type="text" name="password"/>
                            @error('password')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success btn-sm mt-4" value="Update">
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
