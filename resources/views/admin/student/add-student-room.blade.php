@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm học viên</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Thêm học viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form method="POST" id="addStudent" name="addStudent">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông tin lớp</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chọn lớp</label>
                                                <select class="select2" id="room_id" data-placeholder="Select a State"
                                                    style="width:550px">
                                                    @foreach ($room as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text room_id_err"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Chọn kỳ</label>
                                                <select class="select2" id="semester_id" data-placeholder="Select a State"
                                                    style="width:550px">
                                                    @foreach ($semester as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text semester_id_err"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Chọn giáo viên</label>
                                                <select class="select2" id="teacher_id"
                                                    data-placeholder="Mời chọn giáo viên" style="width:550px">

                                                    @foreach ($teacher as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text teacher_id_err"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btn-create">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách học viên</h3>
                                </div>
                                {{-- <input type="hidden" name="id" id="id" value="{{ $id }}">
                                <div class="navbar-search" style="padding:15px">
                                    <form class="form-inline">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-navbar" type="search"
                                                placeholder="Search" id="search" name="search" aria-label="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div> --}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Chọn học viên</label>
                                                <select class="select2" id="student_id" multiple="multiple"
                                                    data-placeholder="Select a State" style="width:550px">
                                                    @foreach ($student as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger error-text student_id_err"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card-body" id="ngu">
                                    @foreach ($student as $row)
                                        <input type="checkbox" value="{{ $row->id }}" name="student_id"
                                            id="student_id">
                                        <label for="{{ $row->id }}">{{ $row->name }}</label>
                                        <button style="width:10px"><i class="fa-solid fa-plus fa-2xs" style="margin:auto"></i></button>
                                        <br>
                                    @endforeach
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('script')
    @parent
    <script>
        $('.select2').select2()
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $('#search').on('keyup', function() {
        //     search = $('#search').val();
        //     $.ajax({
        //         type: 'get',
        //         url: 'admin-add-student',
        //         data: {
        //             'search': search
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             var html = ''
        //             for(let item of data) {
        //                 html += `<input type="checkbox" selected value="`+item.id+`" name="student_id" id="student_id"> <label for="`+item.id+`">`+item.name+`</label><button>thêm</button><br />`;
        //             }
        //             $('#ngu').html(html);
        //         }
        //     });
        // })
        $('#btn-create').click(function(e) {
            e.preventDefault();
            var room_id = $('#room_id').val();
            var teacher_id = $('#teacher_id').val();
            var student_id = $('#student_id').val();
            var semester_id = $('#semester_id').val();
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.addStudent.store') }}",
                dataType: 'json',
                data: {
                    room_id: room_id,
                    teacher_id: teacher_id,
                    student_id: student_id,
                    semester_id: semester_id,
                },
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
                }

            })
        });

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_err').text(value);
            });
        }
    </script>
@endsection
