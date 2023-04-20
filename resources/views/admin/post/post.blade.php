@extends('admin.layout.app')
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
                <table id="data-table" class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Người đăng</th>
                            <th>Loại tin tức</th>
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
                                    <input type="hidden" name="user" id="user" value="{{ auth()->user()->id }}">
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Tên lớp</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="title" name="title"
                                                placeholder="Enter Name" value="" maxlength="50" required="">
                                            <span class="text-danger error-text name_err"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm control-label">Loại tin tức</label>
                                        <div class="col-sm-12">
                                            <select name="post_type" class="select2" style="width:100%" id="post_type"
                                                data-show-subtext="true" data-live-search="true">
                                                @foreach ($type as $type)
                                                    <option selected="selected" value="{{ $type->id }}">
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text post_type_err"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <label>Chi tiết về công ty</label>
                                        <textarea type="text" name="detail" id="detail"></textarea>
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
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('detail');
    </script>
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
                            url: "{{ route('admin-post.index') }}",
                            data: {
                                search: search,
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'title',
                            },
                            // {
                            //     data: 'detail',
                            //     render: function(data, type, row, meta) {
                            //         return '<div data-ckeditor>' + data + '</div>';
                            //     }
                            // },
                            {
                                data: 'user',
                            },
                            {
                                data: 'type',
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ],
                        // columnDefs: [
                        //     // Initialize CKEditor for the "content" column
                        //     {
                        //         targets: 2,
                        //         createdCell: function(td, cellData, rowData, row, col) {
                        //             let editor = CKEDITOR.replace(td, {
                        //                 toolbar: ['undo', 'redo', 'bold', 'italic',
                        //                     'underline'
                        //                 ]
                        //             });
                        //             editor.setData(cellData);
                        //             editor.on('change', function(event) {
                        //                 rowData['content'] = event.editor.getData();
                        //             });
                        //         },
                        //         render: function(data, type, row, meta) {
                        //             return '<div data-ckeditor>' + data + '</div>';
                        //         }
                        //     }
                        // ]
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
                    $.get("{{ route('admin-post.index') }}" + '/' + _id + '/edit', function(data) {
                        $('#modelHeading').html("Sửa lớp học");
                        $('#saveBtn').val("edit-user");
                        $('#ajaxModel').modal('show');
                        $('#_id').val(data.id);
                        $('#title').val(data.title);
                        $('#user').val(data.user);
                        $('#detail').val(data.detail);
                        $("#post_type").val(data.post_type).trigger('change');
                    })
                });
                /* Create Product Code -*/
                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    var detail = CKEDITOR.instances.detail.getData();
                    var title = $('#title').val();
                    var type = $('#post_type').val();
                    var user = $('#user').val();
                    $.ajax({
                        data: {
                            detail: detail,
                            title: title,
                            type: type,
                            user: user,
                        },
                        url: "{{ route('admin-post.store') }}",
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
                                $('#ajaxModel').modal('hide');
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
                                url: "{{ route('admin-post.index') }}" + '/' + _id,
                                success: function(data) {
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
