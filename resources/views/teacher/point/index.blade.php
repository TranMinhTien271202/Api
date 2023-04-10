@extends('teacher.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Điểm</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Điểm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <a class="btn btn-success m-2" href="javascript:void(0)" id="createNewProduct"><i class="fa-solid fa-plus"></i></a>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Điểm</th>
                            <th>Sinh viên</th>
                            <th>Giáo viên</th>
                            <th>Môn học</th>
                            <th>Lớp học</th>
                            <th width="280px">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="modal fade" id="ajaxModel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modelHeading"></h4>
                            </div>
                            <div class="modal-body">
                                <form id="productForm" name="productForm" class="form-horizontal">
                                    <input type="hidden" name="_id" id="_id">
                                    <input type="hidden" name="teacher_id" id="teacher_id"
                                        value="{{ auth('teacher')->user()->id }}">
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Điểm</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="value" name="value"
                                                placeholder="Enter Name" value="" maxlength="50" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Sinh viên</label>
                                        <div class="col-sm-12">
                                            <select name="student_id" class="form-control" id="student_id"
                                                data-show-subtext="true" data-live-search="true">
                                                <option value="">Mời Chọn Sinh Viên</option>
                                                @foreach ($student as $student)
                                                    <option selected="selected" value="{{ $student->id }}">
                                                        {{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Lớp</label>
                                        <div class="col-sm-12">
                                            <select name="subject_id" class="form-control" id="subject_id"
                                                data-show-subtext="true" data-live-search="true">
                                                <option value="">Mời Chọn Môn Học</option>
                                                @foreach ($subject as $subject)
                                                    <option selected="selected" value="{{ $subject->id }}">
                                                        {{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Môn học</label>
                                        <div class="col-sm-12">
                                            <select name="room_id" class="form-control" id="room_id"
                                                data-show-subtext="true" data-live-search="true">
                                                <option value="">Mời Chọn Môn Học</option>
                                                @foreach ($room as $room)
                                                    <option selected="selected" value="{{ $room->id }}">
                                                        {{ $room->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                ajax: "{{ route('point.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'value',
                    },
                    {
                        data: 'students',
                    },
                    {
                        data: 'teachers',
                    },
                    {
                        data: 'subjects',
                    },
                    {
                        data: 'rooms',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            /*Click to Button*/
            $('#createNewProduct').click(function() {
                $('#saveBtn').val("create-product");
                $('#_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Product");
                $('#ajaxModel').modal('show');
            });
            /*Click to Edit Button*/
            $('body').on('click', '.editProduct', function() {
                var _id = $(this).data('id');
                $.get("{{ route('point.index') }}" + '/' + _id + '/edit', function(data) {
                    $('#modelHeading').html("Point");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#_id').val(data.id);
                    $('#value').val(data.value);
                    $('#teacher_id').val(data.teacher_id);
                    $('#student_id').val(data.student_id);
                    $('#subject_id').val(data.subject_id);
                    $('#room_id').val(data.room_id);
                })
            });
            /* Create Product Code -*/
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('point.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#productForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });
            /* Delete Product Code */
            $('body').on('click', '.deleteProduct', function() {
                var _id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('room.index') }}" + '/' + _id,
                    success: function(data) {
                        console.log(data);
                        // table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>
@endsection

</html>
