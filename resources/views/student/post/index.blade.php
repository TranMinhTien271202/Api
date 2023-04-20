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
                        {{-- <span {{$item->status != 1 ? style="color:red" : ""}} >{{ $item->name }}</span> --}}
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
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tin tức</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col col order-2 order-md-1">
                            <div class="row">
                                <div class="col-12">
                                    @foreach ($data as $item)
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm"
                                                    src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                <span class="description">Loại tin tức: {{ $item->PostType->name }}</span>
                                                <span class="description">Đăng bởi: {{ $item->user->email }} -
                                                    {{ $item->created_at }}</span>
                                            </div>
                                            <p>
                                                {{ $item->title }}
                                            </p>
                                            <a href="student-post/{{$item->id}}">Xem chi tiết</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
@endsection
