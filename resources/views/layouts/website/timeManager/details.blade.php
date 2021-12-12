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
              <h3 class="mb-0">Nhân viên:  {{$employee_name}} | Tháng: {{$month}}</h3>
              <h5 style="color: rgb(150, 18, 62)"><span style="color: rgb(13, 110, 29)">@if($working_details != null) Đi làm: {{$working_details->count()}} @endif</span> | <span style="color: rgb(32, 185, 255)">@if($on_leave != null) Phép: {{$on_leave->count()}} @endif</span> | @if($working_details != null && $on_leave != null) Nghỉ: {{31 - $working_details->count() - $on_leave->count()}} @endif</h5>
              @if($employee->regency_id == 1 || $employee->regency_id == 4 || $employee->regency_id == 6)
              <h5 style="color: rgb(116, 20, 92)">Số phép còn lại: {{$employee->leave}} </h5>
              @endif
            </div>
            <div class="card-body">
              @if(isset($working_details))
              <table class="table align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Ngày</th>
                        <th scope="col">Giờ làm(h)</th>
                    </tr>
                </thead>
            <tbody>
                <tr>
                    @for($i = 1; $i<=31; $i++)
                        <tr>
                            <td><span style="font-size: 14px; font-weight: bold;">{{$i}}</span></td>
                            @php
                                    $check = false;
                            @endphp
                            @foreach ($working_details as $item)
                            @php    $day = date('d',strtotime($item->day)); @endphp
                            @if($day == $i)
                            @php
                                $check_overtime =  App\Models\OverTime::where('day','=',$item->day)->where('employee_id','=',$item->employee_id)->first();
                            @endphp
                            <td>
                                @if($check_overtime != null)
                                {{$item->hours + $check_overtime->hours}}
                                @else {{$item->hours}}
                                @endif
                                @php
                                    $check = true;

                                @endphp
                            </td>
                            @endif
                            @php
                                $check_on_leave = App\Models\OnLeave::where('employee_id','=',$item->employee_id)->where('day','=',$i)->first();
                                $check_leave_voluntarily = App\Models\LeaveVoluntarily::where('employee_id','=',$item->employee_id)->where('day','=',$i)->first();
                            @endphp
                            @endforeach
                            @if($check == false)

                                @if($check_on_leave == null)
                                    <td style="color: red; font-weight: bold;"> Nghỉ
                                        <div class="d-inline-flex">

                                            @if($check_leave_voluntarily == null)
                                            <button data-url="{{route('time-manager.leave-voluntarily')}}" data-employee="{{$item->employee_id}}" data-month="{{$month}}" data-day="{{$i}}" class="btn btn-success leave-voluntarily" style="margin-left: 40px; border: none ; background:rgb(116, 63, 20) !important"> Đánh Nghỉ không lý do</button>
                                            @if($item->regency_id == 1 || $item->regency_id == 4 || $item->regency_id == 6)
                                                <button data-url="{{route('time-manager.on-leave')}}" data-employee="{{$item->employee_id}}" data-month="{{$month}}" data-day="{{$i}}" class="btn btn-success onleave" style="margin-left: 40px"> Đánh phép</button>
                                            @endif
                                            @else
                                            <button data-url="{{route('time-manager.delete-leave-voluntarily')}}" data-employee="{{$item->employee_id}}" data-month="{{$month}}" data-day="{{$i}}" class="btn btn-success delete-leave-voluntarily" style="margin-left: 40px; border: none ; background:rgb(20, 26, 116) !important"> Bỏ Nghỉ không lý do</button>
                                            @endif
                                        </div>
                                    </td>
                                    @else <td style="color: rgba(2, 173, 2, 0.993); font-weight: bold;">Phép
                                        @if($item->regency_id == 1 || $item->regency_id == 4 || $item->regency_id == 6)
                                            <button data-url="{{route('time-manager.off-leave')}}" data-employee="{{$item->employee_id}}" data-month="{{$month}}" data-day="{{$i}}" class="btn btn-danger offleave" style="margin-left: 40px"> Bỏ phép</button>
                                        @endif
                                    </td>
                                @endif


                            @endif
                        </tr>
                    @endfor
                </tr>

            </tbody>
            </table>
            @endif
            </div>
          </div>
        </div>
      </div>
      <script>
            $('.onleave').click(function(){
                let employee_id = $(this).attr("data-employee");
                let day = $(this).attr("data-day");
                let month = $(this).attr("data-month");
                let url = $(this).attr("data-url");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        employee_id:employee_id,
                        day:day,
                        month:month,
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
            })

            $('.offleave').click(function(){
                let employee_id = $(this).attr("data-employee");
                let day = $(this).attr("data-day");
                let month = $(this).attr("data-month");
                let url = $(this).attr("data-url");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        employee_id:employee_id,
                        day:day,
                        month:month,
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
            })
            $('.leave-voluntarily').click(function(){
                let employee_id = $(this).attr("data-employee");
                let day = $(this).attr("data-day");
                let month = $(this).attr("data-month");
                let url = $(this).attr("data-url");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        employee_id:employee_id,
                        day:day,
                        month:month,
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    alert(error);
                    }
                });
            })
            $('.delete-leave-voluntarily').click(function(){
                let employee_id = $(this).attr("data-employee");
                let day = $(this).attr("data-day");
                let month = $(this).attr("data-month");
                let url = $(this).attr("data-url");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        employee_id:employee_id,
                        day:day,
                        month:month,
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    alert(error);
                    }
                });
            })
      </script>
      @include('layouts.website_layout.footer')
