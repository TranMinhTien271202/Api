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
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <th scope="row">{{ $key+1 }}</th>
                    <td scope="col">{{ $item->students->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
