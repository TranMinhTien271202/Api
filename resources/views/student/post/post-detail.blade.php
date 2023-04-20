@extends('student.layout.app')
@section('content')
    <div class="content-wrapper">
        <div class="card-body">
            <div class="tab-content">
                <div class="active tab-pane" id="activity">
                    <div class="post">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                            <span class="username">
                                Bài đăng {{$data->title}}
                            </span>
                            <span class="description">Người đăng: {{$data->user->email}} - {{$data->created_at}}</span>
                        </div>
                        <p>
                            {!! $data->detail !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
