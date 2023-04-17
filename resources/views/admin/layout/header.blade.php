<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('auth.profile') }}" class="d-block">{{ auth()->user()->email }}</a>
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
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-teacher.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Giáo viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-student.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Sinh Viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-semester.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Kỳ Học
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-subject.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Môn Học
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-room.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Lớp học
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.addStudent') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Thêm học viên
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
