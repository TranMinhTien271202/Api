@extends('teacher.layout.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Lớp: {{$room->name}} </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Lớp: {{$room->name}} </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <table class="table m-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên Sinh Viên</th>
                <th scope="col" >Quản lý</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td scope="col">{{ $item->students->name }}</td>
                    <td>
                        <a href="" class="btn btn-primary xs">Chi Tiết</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
