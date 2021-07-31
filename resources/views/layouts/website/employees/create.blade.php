@include('layouts.website_layout.head')
@include('layouts.website_layout.header')
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
              <h3 class="mb-0">Thêm Nhân Viên</h3>
              <label>
                <button class="btn btn-success" style="margin-left: 650px"><a href="{{ route('employees.create') }}" style='color: #fff;'>Thêm Nhân Viên</a></button>
              </label>
                
            </div>
            <div class="card-body">
                <form action="{{ route('employees.store') }}" method="post">
                    @csrf
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group name-empl" style="display: flex; align-items: center;">
                            Họ:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='first_name' placeholder="Nguyen..." style='margin-right:40px'>
                            Tên:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='last_name' placeholder="Hong...">
                        </div>
                        <div class="form-group">
                            Giới tính: &nbsp;&nbsp;&nbsp; 
                            <label><input type="radio" name="gender" value="1" id=""> Nam</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="gender" value="0" id=""> Nữ</label>
                            <br>
                            Địa chỉ:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='address'>
                            Email:&nbsp;&nbsp; <input type="email" class="form-control form-control-alternative" name='email'>
                            Điện thoại:&nbsp;&nbsp; <input type="telephone" class="form-control form-control-alternative" name='phone'>
                            Chọn chức vụ: 
                            <select name="regency_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                @foreach ($listRegency as $item)
                                    <option value="{{$item->id}}">{{$item->name_reg}}</option>
                                @endforeach
                            </select>
                            <br>
                            Chọn ca làm: 
                            <select name="shift_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                @foreach ($listShift as $item)
                                    <option value="{{$item->id}}">{{$item->shift_name}}</option>
                                @endforeach
                            </select>
                            <br>
                            Chọn lương: 
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
                  <button class="btn btn-primary btn-sm">Thêm nhân viên</button>
                </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
     
    </div>
  </div>
  @include('layouts.website_layout.footer')