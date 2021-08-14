@include('layouts.website_layout.head')
@include('layouts.website_layout.header')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Check-in & Check-out</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="{{ route('time-keeping.reset') }}" class="btn btn-sm btn-neutral" 
              style="background: rgb(71, 12, 12) !important;  color: white">Reset Check-in/Check-out</i></a>
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
              <h3 class="mb-0">Danh sách chấm công tháng {{($month)}}</h3>
            </div>
            @if (isset($time_keeping) && count($time_keeping) && isset($search))
              <div class="table-responsive" style="padding-top: 10px;">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Họ Tên Nhân Viên</th>
                                <th scope="col">Chấm công</th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr>
                            @foreach ($time_keeping as $item)
                                <tr>
                                  <td>{{$item->first_name . ' ' . $item->last_name}}</td>
                                  <td>{{$item->checked}}</td>
                                </tr>
                            @endforeach
                            
                        </tr>
                        
                    </tbody>
                    </table>   
              </div>
            @elseif(isset($important) && $important != null)
              <span class="d-flex w-100 align-items-center" style="line-height: 40px  ; padding: 10px 10px 10px 300px">{!!$important !!}</span>
            @else
              <div class="card-body">
                <form action="{{ route('time-keeping.import-excel') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="customFile">Trong file excel có các cột Mã nhân viên và check-in</label>
                        <input type="file" name="excel" class="form-control"
                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                            
                            <button class="btn btn-sm btn-neutral" style='margin-top: 20px;'>Import (Excel)</i></button>
                    </div>
                </form>
            </div>
            @endif
            @if(isset($employee_time_keeping) && count($employee_time_keeping))
                <div class="table-responsive" style="padding-top: 10px;">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Họ Tên Nhân Viên</th>
                                <th scope="col">Chấm công</th>
                            </tr>
                        </thead>
                    <tbody>
                        <tr>
                            @foreach ($employee_time_keeping as $item)
                                <tr>
                                  <td>{{$item->first_name . ' ' . $item->last_name}}</td>
                                  <td>{{$item->checked}}</td>
                                </tr>
                            @endforeach
                            
                        </tr>
                        
                    </tbody>
                    </table>   
              </div>
            @endif
          </div>
        </div>
      </div>
      <!-- Footer -->
     
    </div>
  </div>
  @include('layouts.website_layout.footer')