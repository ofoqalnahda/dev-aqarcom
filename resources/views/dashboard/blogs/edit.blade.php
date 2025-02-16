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
                                    <h4 class="card-title">@lang('edit')</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{route('dashboard.blogs.update' , $blog->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('title_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="ar[title]" value="{{$blog->translate('ar')->title}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('title_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="en[title]" value="{{$blog->translate('en')->title}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('description_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" rows="4" name="ar[description]">{{$blog->translate('ar')->description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('description_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea type="text" class="form-control" name="en[description]" rows="4">{{$blog->translate('en')->description}}</textarea>
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
                                                <button type="submit" class="btn btn-primary mr-1">@lang('edit')</button>
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
