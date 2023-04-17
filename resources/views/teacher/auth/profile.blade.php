@extends('teacher.layout.app')
@section('content')
    <div class="content-wrapper">

        <div class="content">
            <div class="container-fluid">
                <h3>
                Thông tin của {{auth('teacher')->user()->name}}
                </h3>
                <form action="" id="form-update" method="POST" role="form" enctype="multipart/form-data">
                    <input type="text" name="id" value="{{ $data->id }}" id="id" hidden>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name </label>
                        <input type="text" id="name" class="form-control" value="{{ $data->name }}"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Phone </label>
                        <input type="text" id="phone" class="form-control" value="{{ $data->phone }}"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Image </label>
                        <input type="file" id="image" class="form-control" value="{{ $data->image }}"
                            id="exampleInputEmail1" aria-describedby="emailHelp">
                            <img src="{{ url('storage/' . $data->image) }}" alt="" title="" width="100px" />
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $(document).ready(function() {
            $('#form-update').submit(function(e) {
                e.preventDefault();
                var file_data = $('#image').prop('files')[0];
                var name = $('#name').val();
                var phone = $('#phone').val();
                var form_data = new FormData();
                form_data.append('name', name);
                form_data.append('phone', phone);
                form_data.append('image', file_data);
                $.ajax({
                    type: 'post',
                    url: 'teacher-profile',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    dataType: 'json',
                    success: function(res) {
                        // alert('Success');
                        console.log(res);
                        location.reload();
                    },
                })
            })
        });
    </script>
@endsection
