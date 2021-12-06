@include('layouts.website_layout.head')
@include('layouts.website_layout.header')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Tính lương</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="{{ route('time-keeping.index') }} " class="btn btn-sm btn-neutral">Import Check-in/Check-out (Excel)</i></a>
              <a href="{{ route('salary.salary-calculation') }}" class="btn btn-sm btn-neutral">Tính toán</i></a>
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
              <h3 class="mb-0">Bảng Lương tháng {{($month)}}</h3>
              <h4 style='color: rgb(7, 105, 15)'>Nhân viên: {{($employee_name)}}</h4>
            </div>
            <div class="card-body">
              @if(isset($data_salary))
              <table class="table align-items-center">
                <thead class="thead-light">
                    <tr style='text-align: center; weight: bold; font-size: 14px;'><td colspan="2">Lương chính</td></tr>
                    <tr>
                        <td width="15%">Lương cơ bản: </td>
                        @php
                            $salary = App\Models\Salary::find($employee->salary_id);
                        @endphp
                        <td text-align="left">{{$data_salary->total_time * $salary->earnings}} VND</td>
                    </tr>
                    <tr>
                        <td>Tổng làm việc:</td>
                        <td>{{$data_salary->total_time}} </td>
                    </tr>
                    <tr>
                        <td>Tổng giờ tăng ca:</td>

                        <td>{{$overtime}} | Lương tăng ca: {{$data_salary->salary_earning - $data_salary->total_time * $salary->earnings}} VND</td>
                    </tr>
                    <tr style='text-align: center; weight: bold; font-size: 14px;'><td colspan="2">Phụ cấp , Thưởng & Phạt</td></tr>
                    @if($regulations != null)
                        @foreach($regulations as $item)
                        @if($item->status == 1)
                            <tr>
                                <td>{{$item->description}}</td>
                                <td>{{$item->amount_of_money}}</td>
                            </tr>
                        @endif
                        @endforeach
                        @foreach($regulations as $item)
                        @if($item->status == 0)
                            <tr>
                                <td>{{$item->description}}</td>
                                <td>{{$item->amount_of_money}}</td>
                            </tr>
                        @endif
                        @endforeach
                    @endif
                    <tr>
                        <td>Thực nhận:</td>
                        <th style='font-size: 15px;'>{{$data_salary->salary_earning}} VND</th>
                    </tr>

                </thead>
            <tbody>
                <tr>


                </tr>

            </tbody>
            </table>
            @endif
            </div>
          </div>
        </div>
      </div>
      @include('layouts.website_layout.footer')

