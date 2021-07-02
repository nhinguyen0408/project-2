@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7" style="margin-top: 1000px; display: flex;">
        <div class="table-responsive" style="padding-top: 100px;">
            <table class="table align-items-center">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Project</th>
                    <th scope="col">Budget</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">
                        Hoc sinh
                    </th>
                    <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </td>
                </tr>
                
            </tbody>
            </table>       
        </div>
    </div>
    
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush