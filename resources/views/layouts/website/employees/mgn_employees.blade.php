@include('layouts.website_layout.head')
@include('layouts.website_layout.header')
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
              <h3 class="mb-0">Nhân viên HCoffee</h3>
              <label>
                <button class="btn btn-success" style="margin-left: 780px"><a href="{{ route('employees.create') }}" style='color: #fff;'>Thêm Nhân Viên</a></button>
              </label>

            </div>
            <div class="card-body">
              <h3 class="mb-0">Vui lòng chọn chức vụ để tìm kiếm nhân viên:</h3>
                <form action="{{ route('employees.index') }}">
                  Chọn chức vụ: <select name="regency_id" id="">
                        <option value="0" selected disabled>------Chọn------</option>
                    @foreach ($listRegency as $item)
                        <option value="{{$item->id}}" @if ($item->id == $idRegency)
                            selected
                        @endif>{{$item->name_reg}}</option>
                    @endforeach
                  </select>

                  </select>
                  <button class="btn btn-primary btn-sm">OK</button>
                </form>
                <div class="table-responsive" style="padding-top: 10px;">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Họ Tên</th>
                                <th scope="col">Địa Chỉ</th>
                                <th scope="col">Giới Tính</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số Điện Thoại</th>
                                <th scope="col">Chức Vụ</th>
                                <th scope="col">Ca làm</th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr>
                            @foreach ($listEmployee as $item)
                                <tr>
                                  <td>{{$item->first_name . ' ' . $item->last_name}}</td>
                                  <td>{{$item->address}}</td>
                                  <td>{{$item->SexName}}</td>
                                  <td>{{$item->email}}</td>
                                  <td>{{$item->phone}}</td>
                                  <td>{{$item->name_reg}}</td>
                                  <td>{{$item->shift_name}}</td>
                                  <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" data-url="{{ route('destroy_emloyee', $item->id) }}">Xóa nhân viên</a>
                                            <a class="dropdown-item" href="{{ route('employees.edit', $item->id) }}">Sửa thông tin</a>
                                            <a class="dropdown-item" href="{{ route('time-keeping.view', $item->id) }}">Xem Lịch Sử Chấm Công</a>
                                            <a class="dropdown-item" href="{{ route('time-manager.details',$item->id) }}">Xem Giờ Làm</a>
                                            <a class="dropdown-item" href="{{ route('salary.details',$item->id) }}">Xem Lương</a>
                                        </div>
                                    </div>
                                  </td>
                                </tr>
                            @endforeach

                        </tr>

                    </tbody>
                    </table>
                    {{ $listEmployee->appends(['search'=>$search,'regency_id'=>$idRegency])->links('pagination::semantic-ui')}}
        </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->

    </div>
  </div>
<script>

</script>
  @include('layouts.website_layout.footer')
