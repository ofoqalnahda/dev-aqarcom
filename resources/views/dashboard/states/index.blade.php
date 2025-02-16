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
                        @can('states-create')
                            <div class="col-lg-12 col-12">
                                <div class="card card-company-table">
                                    <div class="card-body p-1 search-bar">
                                        <a href="{{ route('dashboard.states.create') }}"
                                            class="btn-sm btn-primary">@lang('add')</a>
                                    </div>
                                </div>
                            </div>
                        @endcan

                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('name')</th>
                                                    <th>@lang('control')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($states as $state)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a data-toggle="modal"
                                                                    data-target="#state{{ $state->id }}">
                                                                    <span>{{ $state->name }}</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('states-updateLocationForm')
                                                                    <a href="{{ route('dashboard.states.updateLocationForm', $state->id) }}"
                                                                        class="m-1 btn-sm btn-primary"><i
                                                                            class="fa-solid fa-location-dot"></i></a>
                                                                @endcan
                                                                @can('states-edit')
                                                                    <a href="{{ route('dashboard.states.edit', $state->id) }}"
                                                                        class="btn-sm btn-info">@lang('edit')</a>
                                                                @endcan
                                                                @can('states-destroy')
                                                                    <form
                                                                        action="{{ route('dashboard.states.destroy', $state->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger m-1">@lang('delete')</button>
                                                                    </form>
                                                                @endcan
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @foreach ($states as $state)
                                            <div class="modal fade" id="state{{ $state->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                @lang('cities')</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach ($state->cities as $city)
                                                                <p>{{ $city->name }}</p>
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
