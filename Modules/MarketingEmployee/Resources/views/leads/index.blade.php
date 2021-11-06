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
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-hover table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Lead Status</th>
                                    <th>Lead Date</th>
                                    <th>Employee</th>
                                    <th>Delivery Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Lead Status</th>
                                    <th>Lead Date</th>
                                    <th>Employee</th>
                                    <th>Delivery Status</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @forelse($marketingLeads as $key => $lead)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $lead->name }}</td>
                                        <td>{{ $lead->mobile }}</td>
                                        <td>{{ $lead->email }}</td>
                                        <td>{{ $lead->business_address }}</td>
                                        <td>{{ \Modules\MarketingEmployee\Entities\MarketingLead::$leadStatus[$lead->lead_status] }}</td>
                                        <td>{{ $lead->created_at }}</td>
                                        <td>{{ $lead->lead_employee->name }}</td>
                                        <td>{{ $lead->delivery_status }}</td>
                                        <td width="150px">
                                            <a href="#" class="btn btn-primary btn-sm text-light">
                                                Edit
                                            </a> |
                                            <a href="#"
                                                onclick="return confirm('Are sure want to approve ?')"
                                                class="btn btn-success btn-sm text-light">
                                                Approve
                                            </a> | 
                                            <a href="#"
                                                onclick="return confirm('Are sure want to delete ?')"
                                                class="btn btn-danger btn-sm">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" align="center">Records not found !</td>
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
