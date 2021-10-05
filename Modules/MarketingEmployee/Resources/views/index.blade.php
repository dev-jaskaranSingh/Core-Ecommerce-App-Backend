@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Employees</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Employees</li>
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
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10">
                                    <h5 class="m-0">Employees</h5>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('employee-create')  }}" class="btn btn-info btn-sm">Create
                                        Employee</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @forelse($employees as $key => $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>{{$employee->mobile}}</td>
                                        <td width="150px">
                                            <a href="{{ route('employee-edit',$employee->id) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-pen"></i>
                                            </a> |
                                            <a href="{{ route('employee-delete',$employee->id) }}"
                                               onclick="return confirm('Are sure to delete ?')"
                                               class="btn btn-danger btn-sm text-light">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Records Not Found !</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
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
