@extends('teacher.layout.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kỳ {{$semester->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Kỳ {{$semester->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <table class="table m-3" >
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên lớp</th>
                <th scope="col">Giáo viên</th>
                <th scope="col">Môn học</th>
                <th scope="col">Kỳ học</th>
                <th scope="col">Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->teachers->name }}</td>
                    <td>{{ $item->subjects->name }}</td>
                    <td>{{ $item->semesters->name }}</td>
                    <td>
                        <a href="{{route('syn.student', $item->id)}}" class="btn btn-primary xs">Chi Tiết</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
