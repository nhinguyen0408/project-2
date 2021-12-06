@include('layouts.website_layout.head')
@include('layouts.website_layout.header')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Quản lý giờ làm</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">

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
            <div class="card-header bg-transparent">
              <h3 class="mb-0">Bảng Giờ Làm tháng {{($month)}}</h3>
            </div>
            <div class="card-body">
              @if(isset($data_salary))
              <table class="table align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Họ Tên</th>
                        <th scope="col">Chức vụ</th>
                        <th scope="col">Tổng công làm</th>
                    </tr>
                </thead>
            <tbody>
                <tr>
                    @foreach ($data_salary as $item)
                        <tr>
                          <td>{{$item->first_name . ' ' . $item->last_name}}</td>
                          <td>
                              @php
                                $regency = App\Models\Regency::find($item->regency_id);
                                $shift = App\Models\Shift::find($item->shift_id);
                              @endphp
                              {{$regency->name_reg . ' ' .'('.$shift->shift_name.')'}}
                          </td>
                          <th>{{$item->total_time}}
                            @if($item->regency_id == 1 || $item->regency_id == 4 || $item->regency_id == 6)
                              {{' (công)'}}
                             @else
                             {{' (giờ)'}}
                             @endif
                          </th>

                          <td class="text-right">
                            <div class="dropdown">
                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="{{ route('time-manager.details',$item->employee_id)}}">Xem Chi Tiết</a>
                                </div>
                            </div>
                          </td>
                        </tr>
                    @endforeach

                </tr>

            </tbody>
            </table>
            @endif
            </div>
          </div>
        </div>
      </div>
      @include('layouts.website_layout.footer')
