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
        <center>
            <h1>Teacher Login</h1>
        </center>
        <form style="width:40%;margin:auto" id="LoginForm" name="LoginForm" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                <span class="text-danger error-text email_err"></span>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="password">
                <span class="text-danger error-text password_err"></span>
            </div>
            <button type="submit" id="btn-login" class="btn btn-primary">Login</button>
            <br>
            Chưa có tài khoản vui lòng đăng ký tại đây
            <a href="{{route('teacher.register')}}">Register</a>
        </form>
    </div>
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
        /*Click to Button*/
        $('#createNewProduct').click(function() {
            $('#saveBtn').val("create-product");
            $('#product_id').val('');
            $('#productForm').trigger("reset");
            $('#LoginForm').trigger("reset");
            $('#modelHeading').html("Create New Product");
            $('#ajaxModel').modal('show');
        });
        $('#btn-login').click(function(e) {
            e.preventDefault();
            var _csrf = '{{ csrf_token() }}';
            var url = "{{ route('teacher.login') }}"
            var email = $('#email').val();
            var password = $('#password').val();
            // console.log(url, email, password, _csrf);
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                    _token: _csrf
                },
                success: function(data) {
                    console.log(data);
                    if ($.isEmptyObject(data.message)) {
                        alert(data.success);
                        window.location = '/teacher/subject';
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
    });
</script>

</html>
