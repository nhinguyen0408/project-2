<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Quản lý nhân viên</title>
  <!-- Favicon -->
  <link rel="icon" href="/assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="/assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="/assets/css/argon.css?v=1.2.0" type="text/css">
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="/assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home"></i> {{ __('HOME') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('salary') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Tính lương') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Quản lý') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employees.index') }}">
                                    {{ __('Nhân viên') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    {{ __('Lương') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    {{ __('Thưởng phạt') }}
                                </a>
                            </li>
                        </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text" name="search">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="/assets/img/theme/team-4.jpg">
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{('Nhị Nguyễn')}}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                <div class="dropdown-divider"></div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Quản lý</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row justify-content-center">
        <div class=" col ">
          <div class="card">
            <div class="card-header bg-transparent" style="display: flex; align-items:center">
              <h3 class="mb-0">Sửa Thông Tin</h3>
              <label>
                <button class="btn btn-success" style="margin-left: 650px"><a href="{{ route('employees.create') }}" style='color: #fff;'>Thêm Nhân Viên</a></button>
              </label>
                
            </div>
            <div class="card-body">
                <form action="{{ route('employees.store') }}" method="post">
                    @csrf
                  <div class="row">
                    <div class="col-md-6">
                        Mã Nhân Viên:&nbsp;&nbsp; <input type="text" readonly class="form-control form-control-alternative" value="{{$employee->id}}" name='employee_id'> <br>
                        <div class="form-group name-empl" style="display: flex; align-items: center;">
                            Họ:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='first_name' style='margin-right:40px'
                                value="{{$employee->first_name}}"
                            >
                            Tên:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='last_name' 
                                value="{{$employee->last_name}}"
                            >
                        </div>
                        <div class="form-group">
                            Giới tính: &nbsp;&nbsp;&nbsp; 
                            <label><input type="radio" name="gender" value="1" id=""
                                @if ($employee->gender == 1)
                                    checked
                                @endif
                              > Nam</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="gender" value="0" id=""
                                @if ($employee->gender == 0)
                                    checked
                                @endif
                              > Nữ</label>
                            <br>
                            Địa chỉ:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='address'>
                            Email:&nbsp;&nbsp; <input type="email" class="form-control form-control-alternative" name='email'>
                            Điện thoại:&nbsp;&nbsp; <input type="telephone" class="form-control form-control-alternative" name='phone'>
                            Chức vụ: 
                            <select name="regency_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                @foreach ($listRegency as $item)
                                    <option value="{{$item->id}}">{{$item->name_reg}}</option>
                                @endforeach
                            </select>
                            <br>
                            Ca làm: 
                            <select name="shift_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                @foreach ($listShift as $item)
                                    <option value="{{$item->id}}">{{$item->shift_name}}</option>
                                @endforeach
                            </select>
                            <br>
                            Lương: 
                            <select name="salary_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                    @foreach ($listSalary as $item)
                                        <option value="{{ $item->id }}">{{ $item->earnings }}</option>
                                    @endforeach
                            </select>
                            <br>
                        </div>
                    </div>
                  </div>
                  <button class="btn btn-primary btn-sm">Xác nhận</button>
                </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
     
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="../assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="../assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="../assets/vendor/clipboard/dist/clipboard.min.js"></script>
  <!-- Argon JS -->
  <script src="../assets/js/argon.js?v=1.2.0"></script>
</body>

</html>