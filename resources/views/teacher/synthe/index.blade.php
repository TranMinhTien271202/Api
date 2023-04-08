@extends('teacher.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kỳ học</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Kỳ Học</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <table class="table m-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên kỳ</th>
                    <th scope="col">Ngày bắt đầu</th>
                    <th scope="col">Ngày kết thúc</th>
                    <th scope="col">Quản lý</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ date('m/d/Y', strtotime($item->start_date)) }}</td>
                        <td>{{ date('m/d/Y', strtotime($item->end_date)) }}</td>
                        <td>
                            <a href="{{route('syn.room', $item->id)}}" class="btn btn-primary xs">Chi Tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
