@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7" style="margin-top: 1000px;">  
        @php    
            $check_salary = App\Models\SalaryDetails::first();
            $total_salary_arr = null;
            $i = 5;
            if(isset($check_salary)){
                $total_salary_arr = [];
                do{
                    $salary = App\Models\SalaryDetails::where('month',$i)->get();
                    if(isset($salary) && count($salary)){
                        $total_salary = 0;
                        foreach($salary as $val){
                            $total_salary = $total_salary + $val->salary_earning + $val->bonus_earning - $val->penalize;
                        }
                    } else {
                        $total_salary = 0;
                        
                    }
                    $salary_formatted = number_format($total_salary/1000000,2);
                    array_push($total_salary_arr,$salary_formatted);
                    
                    $i = $i+1;
                } while ($i <=12)   ;
                
            }
            $salary_latest = App\Models\SalaryDetails::where('month',5)->get();
            $total_salary_latest = 0;
            foreach($salary_latest as $val){
                            $total_salary_latest = $total_salary_latest + $val->salary_earning + $val->bonus_earning - $val->penalize;
                        }
        @endphp
        <div class="total_number" style=" display: flex; align-items:center; justify-content: flex-end">
            {{-- Tổng giờ làm nhân viên --}}
            <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body" style=" box-shadow: 10px 10px 5px rgba(61, 61, 61, 0.6)">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Tổng Giờ Làm việc</h5>
                                <span class="h2 font-weight-bold mb-0">2,356 Giờ</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 3.48%</span>
                            <span class="text-nowrap">So với tháng Trước</span>
                        </p>
                    </div>
                </div>
            </div>
            {{-- Tổng lương tháng gần nhất --}}
            <div class="col-xl-4 col-lg-6" style="width: 18rem; padding-left: 15px;">
                <div class="card card-stats mb-4 mb-lg-0">
                    <div class="card-body" style=" box-shadow: 10px 10px 5px rgba(61, 61, 61, 0.6)">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 font-weight-800">Thống Kê Tổng Lương</h5>
                                <span class="h2 font-weight-bold mb-0">{{number_format($total_salary_latest, 0, ',') . ' VND'}}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="mr-2" style="color: red"><i class="fa fa-arrow-down"></i> 3.48%</span>
                            <span class="text-nowrap">So với tháng trước</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>    
        <div class="chart_container" style=" display: flex;">
            {{-- biểu đồ Tổng lương --}}
            <div class="table-responsive" style="padding-top: 40px; padding-bottom: 60px">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Tổng Quan</h6>
                                <h2 class="text-white mb-0">Tổng Lương Theo Tháng</h2>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales" 
                                    data-update='{"data":{
                                        "datasets":[{
                                            "data":[@php $a=0; $len = count($total_salary_arr) @endphp @foreach ($total_salary_arr as $item)@if($a===$len-1)  {{$item}} @else {{$item .','}} @endif @php $a = $a+1; @endphp @endforeach]
                                        }]
                                    }}' 
                                    data-prefix="" data-suffix="M">
                                        <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                            <span class="d-none d-md-block">Xem thống kê</span>
                                            <span class="d-md-none">M</span>
                                        </a>
                                    </li>
                                        {{-- <li class="nav-item" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">
                                            <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                                <span class="d-none d-md-block">Week</span>
                                                <span class="d-md-none">W</span>
                                            </a>
                                        </li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-sales" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>   
            </div>
            {{-- Giờ làm --}}
            <div class="col-xl-4" style="padding-top: 40px; padding-bottom: 60px">
                <div class="card shadow" style=" box-shadow: 10px 10px 5px rgba(219, 218, 218, 0.6) !important">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Thống kê tổng quan</h6>
                                <h2 class="mb-0">Giờ làm việc(M)</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <canvas id="chart-orders" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>   
        </div> 
        
    </div>
    
    
    
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush