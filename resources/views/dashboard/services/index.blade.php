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
                        @can('services-create')
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar">
                                    {{--                                    @php --}}
                                    {{--                                        $queryString = request()->has('type') ? ['type' => request('type')] : []; --}}
                                    {{--                                    @endphp --}}
                                    <a href="{{ route('dashboard.services.create', request()->query()) }}"
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
                                                    <th>@lang('image')</th>
                                                    <th>@lang('name_ar')</th>
                                                    <th>@lang('name_en')</th>
                                                    <th>@lang('is_val_required')</th>
                                                    <th>@lang('control')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($services as $service)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img style="width:50px; height:50px;" class="img-rounded"
                                                                    src="{{ get_file($service->image) }}"
                                                                    alt="blog-image" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $service->translate('ar')->name }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $service->translate('en')->name }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $service->is_val_required?__('required'):__('not_required') }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a class="btn-sm btn-primary m-1" data-toggle="modal"
                                                                data-target="#service{{ $service->id }}">@lang('users')</a>

                                                                @can('services-edit')
                                                                <a href="{{ route('dashboard.services.edit', ['service' => $service->id] + request()->query()) }}"
                                                                    class="btn-sm btn-info">@lang('edit')</a>
                                                                    @endcan
                                                                    @can('services-destroy')

                                                                <form
                                                                    action="{{ route('dashboard.services.destroy', $service->id) }}"
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
                                        @foreach ($services as $service)
                                            <div class="modal fade" id="service{{ $service->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                @lang('users')</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach ($service->users as $user)
                                                                <a
                                                                    href="{{ route('dashboard.users.show', $user->id) }}">{{ $user->name }}</a>
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
