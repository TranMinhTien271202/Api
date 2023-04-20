@extends('admin.layout.app')
@section('style')
    @parent
    <style>
        .upload {
            width: 100px;
            position: relative;
            margin: auto;
        }

        .upload img {
            border-radius: 5px;
            border: 1px solid #eaeaea;
        }

        .upload .round {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #00B4FF;
            width: 32px;
            height: 32px;
            line-height: 33px;
            text-align: center;
            border-radius: 5px;
            overflow: hidden;
        }

        .upload .round input[type="file"] {
            position: absolute;
            transform: scale(2);
            opacity: 0;
        }

        input[type=file]::-webkit-file-upload-button {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <form action="" enctype="multipart/form-data">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="upload">
                        <div class="image-1">
                            <img src="../../dist/img/user4-128x128.jpg" width=100 height=100 alt="">
                        </div>
                        <div class="round">
                            <input type="file" name="image" id="image">
                            <i class="fa fa-camera" style="color: #fff;"></i>
                        </div>
                    </div>
                </div>
                <div class="name" style="width:30%;margin:auto">
                    <label for="name">Họ và tên</label>
                    <input type="text" class="form-control" name="" id="">
                </div>
                <div class="name" style="width:30%;margin:auto">
                    <label for="phone">SDT</label>
                    <input type="text" class="form-control" value="" name="" id="">
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    @parent
    <script>
        $(function() {
            //Reset input file
            $('input[type="file"][name="image"]').val('');
            //Image preview
            $('input[type="file"][name="image"]').on('change', function() {
                var img_path = $(this)[0].value;
                var img_holder = $('.image-1');
                var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

                if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
                    if (typeof(FileReader) != 'undefined') {
                        img_holder.empty();
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('<img/>', {
                                'src': e.target.result,
                                'style': 'width:100px;height:100px;'

                            }).appendTo(img_holder);
                        }
                        img_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        $(img_holder).html('This browser does not support FileReader');
                    }
                } else {
                    $(img_holder).empty();
                }
            });
        })
    </script>
@endsection
