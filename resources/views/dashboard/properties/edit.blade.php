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
                                    <form class="form form-horizontal" action="{{route('dashboard.properties.update' , $property->id)}}" method="POST" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('estate_type')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="estate_type_id" class="form-control">
                                                            <option value="">@lang('select_value')</option>
                                                            @foreach($estateTypes as $estateType)
                                                                <option value="{{$estateType->id}}" {{$property->estate_type_id == $estateType->id ? 'selected' : ''}}>{{$estateType->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('ad_type')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="ad_type_id" class="form-control">
                                                            <option value="">@lang('select_value')</option>
                                                            @foreach($adTypes as $adType)
                                                                <option value="{{$adType->id}}" {{$property->ad_type_id == $adType->id ? 'selected' : ''}}>{{$adType->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('input_type')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="type" class="form-control " id="type-select">
                                                            <option value="">@lang('select_value')</option>
                                                            <option value="slider" {{$property->type == 'slider' ? 'selected' : ''}}>@lang('slider')</option>
                                                            <option value="multi"  {{$property->type == 'multi' ? 'selected' : ''}}>@lang('multi')</option>
                                                            <option value="switch" {{$property->type == 'switch' ? 'selected' : ''}}>@lang('switch')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div {{$property->type == 'slider' ? '' : "style=display:none"}} class="col-12 slider-input">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('min_value')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="min_value" value="{{$property->min_value}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div {{$property->type == 'slider' ? '' : "style=display:none"}} class="col-12 slider-input">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('max_value')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="max_value" value="{{$property->max_value}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_ar')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="ar[name]" value="{{$property->translate('ar')->name}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name_en')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="en[name]" value="{{$property->translate('en')->name}}"  />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label >@lang('show_outside')</label>
                                                    </div>
                                                    <div class="d-flex custom-control custom-control-primary custom-switch">
                                                        <input type="checkbox" class="custom-control-input" name="show_outside" {{$property->show_outside ? 'checked' : ''}} id="customSwitch3" />
                                                        <label class="custom-control-label change-status" for="customSwitch3"></label>
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

                                        <div {{$property->type == 'multi' ? '' : "style=display:none"}} class="card-body select-values">
                                            <table class="table " id="properties-table">
                                                <thead>
                                                <tr>
                                                    <th>@lang('values')</th>
                                                    <th>@lang('control')</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $values_ar = json_decode($property->values_ar);
                                                    $values_en = json_decode($property->values_en);
                                                @endphp
                                                @foreach((array)$values_ar as $index => $value)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <input type="text" class="form-control" name="values[ar][]" value="{{$value}}" placeholder="@lang('value_ar')">
                                                            <input style="margin-left: 5px" type="text" class="form-control" value="{{$values_en[$index]}}" name="values[en][]" placeholder="@lang('value_en')">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn-sm btn-danger delete-row"><i data-feather="trash-2"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <button id="addRow" style="width: 4%;margin-left: 29px;" class="btn btn-primary"><i data-feather="plus"></i></button>
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
                        <input type="text" class="form-control" name="values[ar][]" placeholder="@lang('value_ar')">
                        <input style="margin-left: 5px" type="text" class="form-control" name="values[en][]" placeholder="@lang('value_en')">
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn-sm btn-danger delete-row"><i data-feather="trash-2"></i></button>
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



            $('#type-select').on('change' , function (){
                var value = $(this).val();
                clear();

                if(value === 'slider')
                    $('.slider-input').css('display' , 'block');
                else if(value === 'multi')
                    $('.select-values').css('display' , 'block');

            });



            function clear(){
                $('.slider-input').css('display' , 'none');
                $('.select-values').css('display' , 'none');
                $('.slider-input').find('input').val('');

            }
        </script>
    @endpush

@endsection
