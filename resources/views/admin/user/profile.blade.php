@extends('admin.layout.app')
@section('content')
    <form action="" id="form-update" method="POST">
        <input type="text" name="id" value="{{ $data->id }}" id="id" hidden>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name </label>
            <input type="text" id="name" class="form-control" value="{{ $data->name }}" id="exampleInputEmail1"
                aria-describedby="emailHelp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
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
                $.ajax({
                    type: 'post',
                    url: 'auth-profile',
                    data: {
                        name: $('#name').val(),
                    },
                    dataType: 'json',
                    success: function(res) {
                        // alert('Success');
                        console.log(res);
                        // location.reload();
                    },
                })
            })
        });
    </script>
@endsection
