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
            </div>
            <div class="card-body">

            </div>
          </div>
        </div>
      </div>
      @include('layouts.website_layout.footer')