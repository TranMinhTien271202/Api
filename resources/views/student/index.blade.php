@extends('student.layout.app')
@section('content')
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown" width="350px">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa-regular fa-bell fa-xl" style="padding: 3px"></i>
                    <span class="badge badge-warning navbar-badge" style="font-size: 9px;">{{ count($nofitis) }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">{{ count($nofitis) }} thông báo chưa đọc</span>
                    <div class="dropdown-divider"></div>
                    @foreach ($nofiti as $item)
                        <a href="nofiti/{{ $item->id }}" class="dropdown-item" style="">
                            @if ($item->status == 1)
                                <span>{{ $item->name }}</span>
                            @else
                                <span style="color: red">{{ $item->name }}</span>
                            @endif
                            <span class="float-right text-muted text-sm">{{ $item->created_at }}</span>
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>
    </nav>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ count($teacher) }}</h3>

                                <p>Giáo viên</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <a href="#" class="small-box-footer">Chi tiết <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ count($student) }}</h3>
                                <p>Học viên</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <a href="#" class="small-box-footer">Chi tiết <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ count($subject) }}</h3>
                                <p>Bộ môn</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer">chi tiết<i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            @if ($semester)
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        TOP 5 Sinh Viên Xuất Sắc kỳ {{ $semester->name }}
                                    </h3>
                                </div>
                            @else
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        TOP 5 Sinh Viên Xuất Sắc kỳ
                                    </h3>
                                </div>
                            @endif
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Họ và tên</th>
                                            <th>Lớp</th>
                                            <th>Điểm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td>No {{ $key + 1 }}</td>
                                                <td>{{ $item->students->name }}</td>
                                                <td>{{ $item->rooms->name }}</td>
                                                <td>{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
