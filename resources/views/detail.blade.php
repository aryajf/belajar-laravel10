@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Detail User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Quick Example</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                @if ($data->image)
                                    <img src="{{ $data->image }}" alt="{{ $data->name }}" width="100">
                                @endif
                                <div class="form-group">
                                    <label for="exampleInputEmail">Email address</label>
                                    <div>{{ $data->email }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName1">{{ __('users.name') }}</label>
                                    <div>{{ $data->name }}</div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>{{ __('users.type_rumah') }}</th>
                                            <th>{{ __('users.harga_rumah') }}</th>
                                            <th>{{ __('users.lokasi_rumah') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->rumah as $rumah)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $rumah->type_rumah }}</td>
                                                <td>{{ $rumah->harga_rumah }}</td>
                                                <td>{{ $rumah->lokasi_rumah }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection
