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
                                <form class="form form-horizontal" action="{{route('dashboard.offers.store')}}" method="POST">
                                <div class="card-header">
                                    <h4 class="card-title">@lang('send_notifications')</h4>
                                    <p>
                                        <select class="custom-select form-control" name="to">
                                            @foreach($types as $key => $type)
                                                <option value="{{$key}}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                </div>
                                <div class="card-body">

                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('title')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input class="form-control"  name="title" value="{{old("title")}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('message')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea class="form-control" rows="5" name="message">{{old("title")}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary mr-1">@lang('send')</button>
                                                <button type="reset" class="btn btn-outline-secondary">@lang('reset')</button>
                                            </div>
                                        </div>

                                </div>
                                </form>
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
