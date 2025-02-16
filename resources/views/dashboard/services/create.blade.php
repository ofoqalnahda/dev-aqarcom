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
                                    <form class="form form-horizontal" action="{{route('dashboard.services.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        @if(request()->has('type'))
                                            <input type="hidden" name="type" value="{{request('type')}}" />
                                        @endif
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="ar[name]" value="{{old('ar.name')}}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="en[name]" value="{{old('en.name')}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="sort">@lang('sort')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" id="sort" class="form-control" name="sort" value="{{old('sort')}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group row ">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('is_val_required')</label>
                                                    </div>
                                                    <div class="col-sm-9 form-check">
                                                        <div class="row mx-4">
                                                            <div class="col-3">
                                                                <input type="radio" id="commission_status_true" class="form-check-input" name="is_val_required"  value="1" />
                                                                <label class="form-check-label" for="commission_status_true">
                                                                    مفعل
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <input type="radio" id="commission_status_false" class="form-check-input" name="is_val_required"  value="0" />
                                                                <label class="form-check-label" for="commission_status_false">
                                                                    غير مفعل
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('image')</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="file" class="form-control" name="image" />
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary mr-1">@lang('add')</button>
                                                <button type="reset" class="btn btn-outline-secondary">@lang('reset')</button>
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
@endsection
