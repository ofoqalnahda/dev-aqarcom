@extends('dashboard.layouts.app')

@section('content')
    <!-- BEGIN: Content-->
        <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('add')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.subscriptions.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="ar[name]" value="{{old('ar.name')}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="en[name]" value="{{old('en.name')}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('description_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" rows="4" name="ar[description]">{{old('ar.description')}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('description_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[description]" rows="4">{{old('en.description')}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('regular_ads')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="regular_ads" value="{{old('regular_ads')}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('special_ads')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="special_ads" value="{{old('special_ads')}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('duration_in_days')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="duration" value="{{old('duration')}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('price')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="price" value="{{old('price')}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('old_price')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="old_price" value="{{old('old_price')}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('premium')</label>
                                                    </div>
                                                    <div class="d-flex custom-control custom-control-primary custom-switch">
                                                        <input type="checkbox" class="custom-control-input" name="premium" id="customSwitch3" />
                                                        <label class="custom-control-label change-status" for="customSwitch3"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('add_location')</label>
                                                    </div>
                                                    <div class="d-flex custom-control custom-control-primary custom-switch">
                                                        <input type="checkbox" class="custom-control-input" name="location" id="customSwitch2" />
                                                        <label class="custom-control-label change-status" for="customSwitch2"></label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card-body select-values">
                                                <h2>@lang('interface_features')</h2>
                                                <table class="table " id="properties-table">
                                                    <thead>
                                                    <tr>
                                                        <th>@lang('values')</th>
                                                        <th>@lang('control')</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <input type="text" class="form-control" name="features[ar][]"  placeholder="@lang('value_ar')">
                                                                    <input style="margin-left: 5px" type="text" class="form-control" name="features[en][]" placeholder="@lang('value_en')">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <button class="btn btn-sm btn-danger delete-row"><i data-feather="trash-2"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button id="addRow" class="btn btn-sm btn-primary"><i data-feather="plus"></i></button>
                                            </div>
                                            <div class="col-12">
                                                <button style="width:100%" type="submit" class="btn btn-primary mr-1">@lang('add')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Horizontal form layout section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
        @push('scripts')
    <script>
        $('#addRow').on('click' , function (e){
            e.preventDefault();
            var elements = $('#properties-table tbody tr').length;

            $('#properties-table tbody').append(
            `<tr>
                <td>
                    <div class="d-flex align-items-center">
                        <input type="text" class="form-control" name="features[ar][]" placeholder="@lang('value_ar')">
                        <input style="margin-left: 5px" type="text" class="form-control" name="features[en][]" placeholder="@lang('value_en')">
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-danger delete-row"><i data-feather="trash-2"></i></button>
                    </div>
                </td>
            </tr>`
            );
            feather.replace()
        });

        $(document).on('click' , '.delete-row' , function (e){
            e.preventDefault();

            var elements = $('#properties-table tbody tr').length;
            if(elements > 1)
                $(this).closest('tr').remove();
        });
    </script>
@endpush

@endsection
