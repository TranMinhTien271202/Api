@extends('student.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Danh sách môn</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Lớp </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Môn học</th>
                            <th>Mã môn</th>
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
        $(function() {
            /*Pass Header Token*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*Render DataTable*/
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('student-point.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                    },
                    {
                        data: 'subject',
                    },
                    {
                        data:'subject-code'
                    },
                    {
                        data: 'action',
                    },

                ]
            });
        });
    </script>
@endsection

</html>
