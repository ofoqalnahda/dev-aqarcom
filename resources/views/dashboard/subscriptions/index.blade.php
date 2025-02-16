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
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-1 search-bar" style="justify-content: center;">
                                    <a style="width: 80px;text-align: center;" href="{{route('dashboard.subscriptions.create')}}" class="btn-sm btn-primary">@lang('add')</a>
                                </div>
                            </div>
                        </div>

                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="datatable-table"  class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('title_ar')</th>
                                                <th>@lang('title_en')</th>
                                                <th>@lang('description_ar')</th>
                                                <th>@lang('description_en')</th>
                                                <th>@lang('regular_ads')</th>
                                                <th>@lang('special_ads')</th>
                                                <th>@lang('duration_in_days')</th>
                                                <th>@lang('price')</th>
                                                <th>@lang('premium')</th>
                                                <th>@lang('add_location')</th>
                                                <th>@lang('status')</th>
                                                <th>@lang('control')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subscriptions as $subscription)
                                                    <tr>
                                                        <td>
                                                            {{$loop->iteration}}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$subscription->translate('ar')->name}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span>{{$subscription->translate('en')->name}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{Str::limit($subscription->translate('ar')->description , 50)}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{Str::limit($subscription->translate('en')->description , 50)}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->regular_ads}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->special_ads}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->duration}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->price}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->premium ? __('yes') : __('no')}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap">
                                                            <div class="d-flex flex-column">
                                                                <span class="font-weight-bolder mb-25">{{$subscription->location ? __('yes') : __('no')}}</span>
                                                            </div>
                                                        </td>
                                                        @can('subscriptions-edit')
                                                        <td class="text-nowrap">
                                                            <div class="d-flex custom-control custom-control-primary custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch{{$subscription->id}}" {{$subscription->status? 'checked' : ''}} />
                                                                <label class="custom-control-label changeStatus" for="customSwitch{{$subscription->id}}" data-id="{{$subscription->id}}"></label>
                                                            </div>
                                                        </td>
                                                        @endcan

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('subscriptions-edit')

                                                                <a href="{{route('dashboard.subscriptions.edit' , $subscription->id)}}" class="btn-sm btn-info">@lang('edit')</a>
                                                                @endcan

                                                                @can('subscriptions.destroy')
                                                                    <form action="{{route('dashboard.subscriptions.destroy' , $subscription->id)}}" method="post">
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


@push('scripts')
    <script>
        $('.changeStatus').on('click' , function (){
            var id = $(this).data('id');
            var url = '{{route("dashboard.subscriptions.changeStatus" , ":id")}}';
            url = url.replace(':id' , id);

            $.ajax({
                url: url,
                method: "get",
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: response.success,
                        timeout: 2000,
                        killer: true
                    }).show();
                },
                error: function (response) {
                    console.log(response.responseJSON);
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: response.responseJSON.error,
                        timeout: 2000,
                        killer: true
                    }).show();
                }
            });
        });
    </script>
@endpush
