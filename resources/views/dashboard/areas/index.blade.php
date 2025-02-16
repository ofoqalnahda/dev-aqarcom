@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- dashboard_files Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        @can('areas-create')
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar">
                                    <a href="{{route('dashboard.areas.create')}}" class="btn-sm btn-out">@lang('add')</a>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table"  class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('name')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($areas as $area)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a data-toggle="modal" data-target="#area{{$area->id}}">
                                                                    <span>{{$area->name}}</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('areas-edit')
                                                                    <a href="{{route('dashboard.areas.edit' , $area->id)}}" class="btn-sm btn-info">@lang('edit')</a>
                                                                   @endcan
                                                                   @can('areas-destroy')
                                                                    <form action="{{route('dashboard.areas.destroy' , $area->id)}}" method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit" class="btn btn-sm btn-danger m-1">@lang('delete')</button>
                                                                    </form>
                                                                     @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @foreach($areas as $area)
                                                <div class="modal fade" id="area{{$area->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">@lang('cities')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                            @foreach($area->cities as $city)
                                                                <p>{{$city->name}}</p>
                                                                <hr>
                                                            @endforeach
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Company Table Card -->
                    </div>
                </section>
                <!-- dashboard_files Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
