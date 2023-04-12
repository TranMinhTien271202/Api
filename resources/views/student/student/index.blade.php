@extends('student.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Danh sách sinh viên lớp: {{$room->name}} </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">{{$room->name}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <table class="table table-bordered data-table" id="data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sinh viên</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->students->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! $data->links() !!}
        </div>
    </div>
@endsection
