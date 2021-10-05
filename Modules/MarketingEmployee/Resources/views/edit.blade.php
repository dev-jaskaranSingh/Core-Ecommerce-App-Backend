@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Employee</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Employee</li>
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
                            <h5 class="m-0">Edit Employee</h5>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <lable>Name*</lable>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <lable>Mobile*</lable>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <lable>Password*</lable>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" class="btn btn-success btn-sm mt-4" value="Save">
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
