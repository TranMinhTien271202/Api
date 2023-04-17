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
                            <li class="breadcrumb-item active">Kỳ học</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                {{-- <a class="btn btn-success xs btn-sm" href="javascript:void(0)" id="createNewProduct"><i class="fa-solid fa-plus"></i></a> --}}
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên kỳ</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            {{-- <th width="280px">Quản lý</th> --}}
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
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Tên kỳ</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter Name" value="" maxlength="50" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Ngày bắt đầu</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                placeholder="Enter Name" value="" maxlength="50" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Ngày kết thúc</label>
                                        <div class="col-sm-12">
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                placeholder="Enter Name" value="" maxlength="50" required="">
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
                ajax: "{{ route('semester.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'start_date',
                    },
                    {
                        data: 'end_date',
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ]
            });
            /*Click to Button*/
            $('#createNewProduct').click(function() {
                $('#saveBtn').val("CreateSemester");
                $('#_id').val('');
                $('#productForm').trigger("reset");
                $('#modelHeading').html("Create New Semester");
                $('#ajaxModel').modal('show');
            });
            /*Click to Edit Button*/
            $('body').on('click', '.editProduct', function() {
                var _id = $(this).data('id');
                $.get("{{ route('semester.index') }}" + '/' + _id + '/edit', function(data) {
                    $('#modelHeading').html("Update Semester");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#_id').val(data.id);
                    $('#name').val(data.name);
                    $('#start_date').val(data.start_date);
                    $('#end_date').val(data.end_date);
                })
            });
            /* Create Product Code -*/
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                $.ajax({
                    data: $('#productForm').serialize(),
                    url: "{{ route('semester.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if ($.isEmptyObject(data.message)) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            })
                            setTimeout(() => {
                                $('#productForm').trigger("reset");
                                $('#ajaxModel').modal('hide');
                                table.draw();
                            }, 300);
                        } else {
                            printErrorMsg(data.message);
                        }
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
                Swal.fire({
                    title: 'Are you sure you want to delete?',
                    text: "You won't be able to undo this once you do!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('semester.index') }}" + '/' + _id,
                            success: function(data) {
                                if (data.status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        data.success,
                                        'success'
                                    )
                                    table.draw();
                                } else {
                                    Swal.fire(
                                        'Deleted!',
                                        data.error,
                                        'error'
                                    )
                                }
                                table.draw();
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection

</html>
