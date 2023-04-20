<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('auth.profile') }}" class="d-block">{{ auth('student')->user()->name }}</a>
            </div>
            <div class="info">
                <a href="logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>

        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Thống kê
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="student-post" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Tin tức
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student-room.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh sách Lớp
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student-point.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Điểm
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('send-point.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Thông báo điểm
                        </p>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>
