<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('dist/css/login.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <h2>Đăng nhập sinh viên</h2>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST">
                <h1>Đăng nhập</h1>
                <input type="email" id="email" placeholder="Email" />
                <span class="text-danger error-text email_err"></span>
                <input type="password" id="password" placeholder="Password" />
                <span class="text-danger error-text password_err"></span>
                <a href="#">Quên mật khẩu?</a>
                <button type="submit" id="btn-login" >Đăng nhập</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Chào bạn</h1>
                    <p>Hãy đăng ký tài khoản để đồng hành cùng chúng tôi.</p>
                    <a href="{{route('auth.register')}}"><button class="ghost" id="signUp">Đăng ký</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        $('#btn-login').click(function(e) {
            e.preventDefault();
            var _csrf = '{{ csrf_token() }}';
            var url = "{{ route('auth.login') }}"
            var email = $('#email').val();
            var password = $('#password').val();
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
                        if (data.status == 1) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            })
                            setTimeout(() => {
                                window.location = '/admin/admin-subject';
                            }, 800);
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            })
                        }
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
</body>

</html>
