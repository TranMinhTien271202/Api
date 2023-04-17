@extends('student.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lớp</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Lớp</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <a class="btn btn-success xs btn-sm" href="javascript:void(0)" id="createNewProduct"><i
                        class="fa-solid fa-plus"></i></a>
                <select class="select2" style="width:15%;padding-bottom: 4px;" id="search" data-placeholder="Chọn kỳ"
                    style="width: 100%;">
                    @foreach ($semester as $row)
                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-search"
                    style="padding-bottom: 5px;border-radius: 5px;height:30px"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
                <table id="data-table" class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên lớp</th>
                            <th>Giáo viên</th>
                            <th>Môn học</th>
                            <th>Kỳ Học</th>
                            <th width="280px">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script>
        $('.select2').select2()
    </script>
    <script type="text/javascript">
        $(function() {
            /*Pass Header Token*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*Render DataTable*/
            $(document).ready(function() {
                fill_datatable();

                function fill_datatable(search = '') {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ route('student-room.index') }}",
                            data: {
                                search: search,
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'name',
                            },
                            {
                                data: 'teachers',
                            },
                            {
                                data: 'subjects',
                            },
                            {
                                data: 'semesters',
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });

                }
                $('#btn-search').click(function() {
                    var search = $('#search').val();
                    $.ajax({
                        data: {
                            search: search,
                        },
                        url: "{{ route('student-room.index') }}",
                        type: "GET",
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $('.data-table').DataTable().destroy();
                            fill_datatable(search);
                        },
                    });
                });
                $('#reset').click(function() {
                    $('#semester').val('');
                    $('#data-table').DataTable().destroy();
                    fill_datatable();
                });
            });
            /*Click to Button*/
        });
    </script>
@endsection
