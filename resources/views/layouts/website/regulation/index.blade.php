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
              <h3 class="mb-0">Quản lý lương thưởng</h3>
            </div>
            <div class="card-body">
                <span style="font-size:20px; color:black; font-weight:bold">Thưởng</span>
                <p></p>
                <div style="border: 1px solid rgb(78, 76, 76); border-radius: 5px; padding: 5px 15px">
                    <h4>Nhập thưởng cho toàn nhân viên:</h4>
                    Số tiền: <input type="text" placeholder="100 000 VND" class="form-control" id="amount-of-money" />
                    Nội dung: <input type="text" placeholder="Thưởng..." class="form-control" id="description"/>
                    <button type="button" data-url="{{ route('regulations.bonus-all') }}" class="btn btn-default" id="bonus">Ok</button>
                    <div>
                        <p></p>
                        <h5>Lịch sử thưởng toàn nhân viên</h5>
                        @if($bonus_all != null)
                            <table width="100%" border="0" cellspacing="" class="table align-items-center">
                                <tr>
                                    <th width='20%'>Số tiền</th>
                                    <th width='50%'>Nội dung</th>
                                    <td></td>
                                </tr>
                                @foreach ($bonus_all as $item)
                                    <tr>
                                        <td>
                                            {{number_format($item->amount_of_money, 0, ',')}} VND
                                        </td>
                                        <td>
                                            {{$item->description}}
                                        </td>
                                        <td>
                                            <button data-url="{{ route('regulations.abort-bonus') }}" data-id="{{$item->id}}" style="background:rgb(117, 47, 47); border:none" type="button" class="btn btn-primary btn-sm abort-bonus">Hủy thưởng</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                </div>

                <span style="font-size:20px; color:black; font-weight:bold">Phạt</span>
                <p></p>
                <div style="border: 1px solid rgb(78, 76, 76); border-radius: 5px; padding: 5px 15px">
                    <h4>Xử phạt nhân viên</h4>
                    Tìm nhân viên: <select class="form-select" aria-label="Default select example" name="employee" id="">
                        <option value="-1" selected>Chọn nhân viên</option>
                        @if(isset($employees))
                        @foreach($employees as $item)
                            <option value="{{$item->id}}">{{$item->first_name ." " . $item->last_name}}</option>
                        @endforeach
                        @endif
                    </select> <br>
                    Số tiền: <input type="text" placeholder="100 000 VND" class="form-control" id="amount" />
                    Nội dung xử phạt: <input type="text" placeholder="Phạt vì sao..." class="form-control" id="penazile-des"/>
                    <button type="button" data-url="{{ route('regulations.penazile') }}" class="btn btn-default" id="penazile">Ok</button>
                    <div>
                        <p></p>
                        <h5>Lịch sử xử phạt nhân viên</h5>
                        @if($regulation != null)
                            <table width="100%" border="0" cellspacing="" class="table align-items-center">
                                <tr>
                                    <th width='10%'>Nhân viên</th>
                                    <th width='10%'>Số tiền</th>
                                    <th width='50%'>Nội dung</th>
                                    <td></td>
                                </tr>
                                @foreach ($regulation as $item)
                                    <tr>
                                        <td>{{$item->first_name . ' ' . $item->last_name}}</td>
                                        <td>
                                            {{number_format($item->amount_of_money, 0, ',')}} VND
                                        </td>
                                        <td>
                                            {{$item->description}}
                                        </td>
                                        <td>
                                            <button data-url="{{ route('regulations.abort-penazile') }}" data-id-em="{{$item->employee_id}}" data-id-pen="{{$item->id}}" style="background:rgb(117, 47, 47); border:none" type="button" class="btn btn-primary btn-sm abort-penazile">Hủy phạt</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>

                </div>

            </div>
          </div>
        </div>
      </div>
      <script>
          function validateNumber(txt) {
                    var a = $('#amount-of-money').val();
                    var b = $('#description').val();
                    var filter = /^[0-9]*$/;
                    if (filter.test(a) & b.length != 0) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
        function validatePenazile(txt) {
            var a = $('#amount').val();
            var b = $('#penazile-des').val();
            var filter = /^[0-9]*$/;
            if (filter.test(a) & b.length != 0) {
                return true;
            }
            else {
                return false;
            }
        }
          $('#bonus').click(function(){
            var number = $('#amount-of-money').val();
            var description = $('#description').val();
            var url = $(this).attr("data-url");
            if(validateNumber(number)){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        number:number,
                        description:description,
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
            }
            else{
                alert("Nhap lai");
            }
          })
          $('.abort-bonus').click(function(){
            var id = $(this).attr("data-id");
            var url = $(this).attr("data-url");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        id:id,

                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
          })
          $('#penazile').click(function(){
            var number = $('#amount').val();
            var description = $('#penazile-des').val();
            var employee_id = $('select[name=employee] option').filter(':selected').val();
            var url = $(this).attr("data-url");
            if(validatePenazile(number)){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type:"POST",
                    data:{
                        number:number,
                        description:description,
                        employee_id:employee_id,
                    },
                    success:function(data){
                        location.reload();
                    },
                    error: function(data) {
                        alert('Số tiền phạt vượt quá lương nhân viên !!!!!');
                    }
                });
            }
            else{
                alert("Nhap lai");
            }
          })
          $('.abort-penazile').click(function(){
            var employee_id = $(this).attr("data-id-em");
            var regulation_id = $(this).attr("data-id-pen");
            var url = $(this).attr("data-url");
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
                        regulation_id:regulation_id,
                    },
                    success:function(response){
                        location.reload();
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
          })
      </script>
      @include('layouts.website_layout.footer')

