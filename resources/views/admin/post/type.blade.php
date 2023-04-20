@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Loại tin tức</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Loại tin tức</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <a class="btn btn-success xs btn-sm" href="javascript:void(0)" id="createNewProduct"><i
                        class="fa-solid fa-plus"></i></a>
                <table id="data-table" class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên loại</th>
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
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Tên loại tin tức</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter Name" value="" maxlength="50" required="">
                                            <span class="text-danger error-text name_err"></span>
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
                            url: "{{ route('admin-post-type.index') }}",
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
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });

                }
                $('#createNewProduct').click(function() {
                    $('#saveBtn').val("create-product");
                    $('#_id').val('');
                    $('#productForm').trigger("reset");
                    $('#modelHeading').html("Thêm mới lớp học");
                    $('#ajaxModel').modal('show');
                });
                /*Click to Edit Button*/
                $('body').on('click', '.editProduct', function() {
                    var _id = $(this).data('id');
                    $.get("{{ route('admin-post-type.index') }}" + '/' + _id + '/edit', function(
                        data) {
                        $('#modelHeading').html("Sửa lớp học");
                        $('#saveBtn').val("edit-user");
                        $('#ajaxModel').modal('show');
                        $('#_id').val(data.id);
                        $('#name').val(data.name);
                    })
                });
                /* Create Product Code -*/
                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        data: $('#productForm').serialize(),
                        url: "{{ route('admin-post-type.store') }}",
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
                                        toast.addEventListener(
                                            'mouseenter',
                                            Swal.stopTimer)
                                        toast.addEventListener(
                                            'mouseleave',
                                            Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: data.success
                                })
                                $('#productForm').trigger("reset");
                                $('#data-table').DataTable().destroy();
                                fill_datatable();
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
                            var _id = $(this).data("id");
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin-post-type.index') }}" + '/' +
                                    _id,
                                success: function(data) {
                                    if (data.status == 1) {
                                        const Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast
                                                    .addEventListener(
                                                        'mouseenter',
                                                        Swal
                                                        .stopTimer)
                                                toast
                                                    .addEventListener(
                                                        'mouseleave',
                                                        Swal
                                                        .resumeTimer
                                                    )
                                            }
                                        })
                                        Toast.fire({
                                            icon: 'success',
                                            title: data.success
                                        })
                                        $('#data-table').DataTable().destroy();
                                        fill_datatable();
                                    }else{
                                        const Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast
                                                    .addEventListener(
                                                        'mouseenter',
                                                        Swal
                                                        .stopTimer)
                                                toast
                                                    .addEventListener(
                                                        'mouseleave',
                                                        Swal
                                                        .resumeTimer
                                                    )
                                            }
                                        })
                                        Toast.fire({
                                            icon: 'error',
                                            title: data.success
                                        })
                                        $('#data-table').DataTable().destroy();
                                        fill_datatable();
                                    }
                                },
                                error: function(data) {
                                    console.log('Error:', data);
                                }
                            });
                        }
                    })
                });
            });
        });

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_err').text(value);
            });
        }
    </script>
@endsection
