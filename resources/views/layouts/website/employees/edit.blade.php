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
              <h3 class="mb-0">Sửa Thông Tin</h3>
              <label>
                <button class="btn btn-success" style="margin-left: 650px"><a href="{{ route('employees.create') }}" style='color: #fff;'>Thêm Nhân Viên</a></button>
              </label>
                
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="post">
                  @method("PUT")
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
                            Địa chỉ:&nbsp;&nbsp; <input type="text" class="form-control form-control-alternative" name='address' value="{{$employee->address}}">
                            Email:&nbsp;&nbsp; <input type="email" class="form-control form-control-alternative" name='email' value="{{$employee->email}}">
                            Điện thoại:&nbsp;&nbsp; <input type="telephone" class="form-control form-control-alternative" name='phone' value="{{$employee->phone}}">
                            Chức vụ: 
                            <select name="regency_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                @foreach ($listRegency as $item)
                                    <option value="{{$item->id}}" @if ($employee->regency_id == $item->id)
                                        selected
                                    @endif>{{$item->name_reg}}</option>
                                @endforeach
                            </select>
                            <br>
                            Ca làm: 
                            <select name="shift_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                @foreach ($listShift as $item)
                                    <option value="{{$item->id}}" @if ($employee->shift_id == $item->id)
                                        selected
                                    @endif>{{$item->shift_name}}</option>
                                @endforeach
                            </select>
                            <br>
                            Lương: 
                            <select name="salary_id" id="">
                                    <option value="0" selected disabled>------Chọn------</option>
                                    @foreach ($listSalary as $item)
                                        <option value="{{ $item->id }}" @if ($employee->salary_id == $item->id)
                                        selected
                                    @endif>{{ $item->earnings }}</option>
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
  @include('layouts.website_layout.footer')