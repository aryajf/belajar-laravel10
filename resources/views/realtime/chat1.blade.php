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
                            <li class="breadcrumb-item active">Email: Bambang@gmail.com</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <a href="mailbox.html" class="btn btn-primary btn-block mb-3">Back to Inbox</a>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Folders</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item active">
                                        <a href="#" class="nav-link">
                                            <i class="fas fa-inbox"></i>
                                            <span class="badge bg-primary float-right" id="inbox">0</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form action="{{ route('admin.realtime.send-message') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <!-- general form elements -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Compose New Message</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="to">TO:</label>
                                                <input type="text" class="form-control" id="to" placeholder="To:"
                                                    name="to">
                                                @error('to')
                                                    <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="subject">Subject</label>
                                                <input type="text" class="form-control" id="subject"
                                                    placeholder="Subject:" name="subject">
                                                @error('subject')
                                                    <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="message">Password</label>
                                                <textarea name="pesan" id="message" class="form-control" id="compose-textarea" rows="10"
                                                    placeholder="Messages:"></textarea>
                                                @error('pesan')
                                                    <div class="text-danger text-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="button" class="btn btn-default">Draft</button>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        {!! Vite::content('resources/js/app.js') !!}
    </script>
@endsection
