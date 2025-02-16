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
                                    <form class="form form-horizontal" action="{{route('dashboard.sections.update' , 'id')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="category">@lang('section_name')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select id="page-select" name="category_id" id="category" class="form-control">
                                                            <option value="" >@lang('select_value')</option>
                                                            @foreach($sections as $section)
                                                                <option value="{{$section->id}}">{{__($section->section_name)}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="category">@lang('section_name')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="file" name="images[]" multiple="multiple" />
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach($sections as $section)
                                                    <div class="col-12 sections"  id="section{{$section->id}}" style="display: none">
                                                        <div class="form-group row">
                                                            <div class="col-sm-3 col-form-label">
                                                                <label for="category">@lang('images')</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                @foreach((array)$section->images->toArray() as $image)
                                                                    <img class="img-rounded" style="width: 70px;height: 70px ; margin: 5px" src="{{get_file($image['image'])}}" alt="">
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary mr-1">@lang('edit')</button>
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
            $('#page-select').on('change' , function (){
                var id = $(this).find(":selected").val();
                var url  = '{{route('dashboard.sections.update' , ':id')}}';
                url = url.replace(':id' , id);
                $(this).closest('form').attr('action' , url);
                $('.sections').css('display' , 'none');
                $('#section'+id).css('display' , 'block');
            });
        </script>
    @endpush
@endsection
