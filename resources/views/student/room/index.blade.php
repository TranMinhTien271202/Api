@extends('student.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Danh sách lớp</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách lớp</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <select name="semester" class="form-select" id="semester">
                <option value="">Mời chọn kỳ học</option>
                @foreach ($semester as $row)
                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
            <button type="submit" id="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            <div class="container-fluid">
                <table class="table table-bordered data-table" id="data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên lớp</th>
                            <th>Quản lý</th>
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
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            fill_datatable();

            function fill_datatable(semester = '') {
                var dataTable = $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('student-room.index') }}",
                        data: {
                            semester: semester,
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                        },
                        {
                            data: 'room',
                        },
                        {
                            data: 'action',
                        },
                    ]
                });
            }
            $('#btn-search').click(function() {
                var semester = $('#semester').val();
                if (semester != '') {
                    $.ajax({
                        data: {
                            semester: semester,
                        },
                        url: "{{ route('student-room.index') }}",
                        type: "GET",
                        dataType: 'json',
                        success: function(res) {
                            console.log(res);
                            $('#data-table').DataTable().destroy();
                            fill_datatable(semester);
                        },
                    });
                } else {
                    alert('Select Both filter option');
                }
            });
            $('#reset').click(function() {
                $('#semester').val('');
                $('#data-table').DataTable().destroy();
                fill_datatable();
            });

        });
    </script>
@endsection

</html>
