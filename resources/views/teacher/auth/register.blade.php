<!DOCTYPE html>
<html>

<head>
    <title>Laravel Ajax CRUD Tutorial Example - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
    <div class="container">
        <center><h1>Student Register</h1></center>
        <form style="width:40%;margin:auto" id="LoginForm" name="LoginForm" method="POST">
            <input type="text" name="_token" id="_token" value="{{ csrf_token() }}" hidden>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                    placeholder="Mời nhập họ và tên">
                <span class="text-danger error-text name_err"></span>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                    placeholder="Mời nhập email">
                <span class="text-danger error-text email_err"></span>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" name="password" id="password"
                    placeholder="Mời nhập mật khẩu">
                <span class="text-danger error-text password_err"></span>
            </div>
            <button type="submit" id="btn-create" class="btn btn-primary">Register</button>
            <br>
            Đã có tài khoản vui lòng đăng nhập tại đây
            <a href="{{route('teacher.index')}}">Login</a>
        </form>
    </div>
</body>

<script type="text/javascript">
    $(function() {
        /*Pass Header Token*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#btn-create').click(function(e) {
            e.preventDefault();
            $(this).html('loading...');
            var _token = $("input[name='_token']").val();
            var url = "{{ route('teacher.register.post') }}"
            var email = $('#email').val();
            var password = $('#password').val();
            var name = $('#name').val();
            console.log(url, email, password, name);
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    email: email,
                    password: password,
                    name: name,
                },
                success: function(data) {
                    console.log(data);
                    if ($.isEmptyObject(data.message)) {
                        alert(data.success);
                        // window.location = '/auth';
                    } else {
                        printErrorMsg(data.message);
                    }
                    // alert(data.success);

                }

            })
        });

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                console.log(key);
                $('.' + key + '_err').text(value);
            });
        }
    });
</script>

</html>
