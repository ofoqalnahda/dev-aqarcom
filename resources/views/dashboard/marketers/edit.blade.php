@extends('dashboard.layouts.app')
@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2-selection__arrow {
            display: none;
        }
        span.select2-selection__clear {
            display: none;
        }
    </style>
@endsection
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
                                    <form class="form form-horizontal" action="{{route('dashboard.marketers.update' , $marketer->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="user_id">@lang('user')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select id="user_id" name="user_id" class="form-control"  required>
                                                            <option value="" disabled @if(!$marketer->user_id) selected @endif>@lang('select_value')</option>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @if($marketer->user_id == $user->id) selected @endif >
                                                                    {{ $user->name .' - ' .$user->phone }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('name')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="name" value="{{$marketer->name}}" placeholder="الاسم" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="email-id">@lang('email')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="email" id="email-id" class="form-control" name="email" value="{{$marketer->email}}" placeholder="example@gmail.com" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('phone')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="phone" value="{{$marketer->phone}}" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('identity_number')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="identity_number" value="{{$marketer->identity_number}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="discount_type">@lang('discount_type')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select required name="discount_type" id="discount_type" class="form-control">
                                                            <option @selected( $marketer->discount_type=="fixed") value="fixed">@lang('discount_fixed')</option>
                                                            <option @selected($marketer->discount_type=="percent") value="percent">@lang('discount_percent')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('discount_percentage')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="discount_percentage" value="{{$marketer->discount_percentage}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="code">@lang('code')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="code" class="form-control" name="code" value="{{$marketer->code}}" required />
                                                    </div>
                                                </div>
                                            </div> 
                                           {{--  <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="subscriptions">الباقات المتاحه للخصم </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select id="page-select" name="subscription_ids[]" id="subscriptions" class="form-control" multiple required>
                                                            <option value="" disabled >@lang('select_value')</option>
                                                            @foreach($subscriptions as $subscription)
                                                                <option value="{{$subscription->id}}" {{in_array($subscription->id,$marketer->subscription_ids?? []) ? 'selected' : ''}} >{{$subscription->name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>--}}
                                            
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="first-name">@lang('commission_percentage')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="first-name" class="form-control" name="commission_percentage" value="{{$marketer->commission_percentage}}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="target_count">@lang('target_count')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" id="target_count" class="form-control"
                                                            name="target_count"
                                                            value="{{ old('target_count',$marketer->target_count) }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="code">@lang('commission_target')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" id="commission_target" class="form-control"
                                                            name="commission_target" value="{{ old('commission_target',$marketer->commission_target) }}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="concerned_party">@lang('concerned_party')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="concerned_party" class="form-control"
                                                            name="concerned_party" value="{{ old('concerned_party',$marketer->concerned_party) }}"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="subscriptions">@lang('package_to_comm')  </label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select id="subscriptions-select" name="subscription_ids[]" class="form-control" multiple required>
                                                            <option value="" disabled>@lang('select_value')</option>
                                                            @foreach ($subscriptions as $subscription)
                                                                <option value="{{ $subscription->id }}" 
                                                                    @if (isset($oldSubscriptions) && array_key_exists($subscription->id, $oldSubscriptions)) selected @endif>
                                                                    {{ $subscription->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-3">
                                                    <div class="col-12">
                                                        <table class="table table-bordered" id="subscriptions-table" style="display: none;">
                                                            <thead>
                                                                <tr>
                                                                    <th>@lang('package')</th>
                                                                    <th>@lang('commission_percentage')</th>
                                                                    <th>@lang('discount_percentage')</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="subscriptions-body">
                                                                @if (isset($oldSubscriptions))
                                                                    @foreach ($oldSubscriptions as $id => $value)
                                                                        <tr data-id="{{ $id }}">
                                                                            <td>{{ $subscriptions->find($id)->name }}</td>
                                                                            <td>
                                                                                <input type="number" name="subscription_commission_percentage[{{ $id }}]" class="form-control" 
                                                                                     placeholder="{{__('enter_value')}}"  value="{{ $value['commission_percentage'] }}" required>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" name="subscription_discount_percentage[{{ $id }}]" class="form-control" 
                                                                                     placeholder="{{__('enter_value')}}"  value="{{ $value['discount_percentage'] }}" required>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>



                                            
                                             <div class="col-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-3 col-form-label">
                                                        <label for="password">@lang('image')</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="image" />
                                                    </div>
                                                </div>
                                            </div>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
            <script>
                $("#user_id").select2({
                    allowClear: true
                });
            </script>
            <script>

                $(document).on('change', '#first-name', function() {
                    let name= $('#first-name').val();
                    getCode(name);
                });
                $(document).on('change', '#user_id', function() {
                    let user_id= $('#user_id').val();
                    $.ajax({
                        method: "get",
                        url: "{{route('dashboard.marketers.getData')}}",
                        data: {
                            user_id: user_id
                        },
                        success: function (result) {
                            if (result.success) {
                                $('#first-name').val(result.data.name);
                                $('#phone').val(result.data.phone);
                                $('#email-id').val(result.data.email);
                                getCode(result.data.name);
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: result.text,
                                });
                                console.log(result);
                            }


                        },
                    });
                });

                function getCode(name) {

                    $.ajax({
                        method: "get",
                        url: "{{route('dashboard.marketers.getCode')}}",
                        data: {
                            name: name,
                        },
                        success: function (result) {
                            if (result.success) {
                                $('#code').val(result.data.code);
                            } else {
                                console.log(result);
                            }


                        },
                    });

                }
            document.addEventListener('DOMContentLoaded', function () {
                const selectElement = document.getElementById('subscriptions-select');
                const table = document.getElementById('subscriptions-table');
                const tableBody = document.getElementById('subscriptions-body');
        
                if (tableBody.children.length > 0) {
                    table.style.display = '';
                }
        
                selectElement.addEventListener('change', function () {
                    const selectedOptions = Array.from(selectElement.selectedOptions);
                    const existingRows = Array.from(tableBody.querySelectorAll('tr'));
        
                    const existingMap = new Map();
                    existingRows.forEach(row => {
                        const optionId = row.dataset.id;
                        existingMap.set(optionId, row);
                    });
        
                    if (selectedOptions.length > 0) {
                        table.style.display = ''; 
                    } else {
                        table.style.display = 'none';
                    }
        
                    selectedOptions.forEach(option => {
                        if (!existingMap.has(option.value)) {
                            const row = document.createElement('tr');
                            row.dataset.id = option.value;
                            row.innerHTML = `
                                <td>${option.text}</td>
                                <td>
                                    <input type="number" name="subscription_commission_percentage[${option.value}]" class="form-control" placeholder="{{__('enter_value')}}" required>
                                </td>
                                <td>
                                    <input type="number" name="subscription_discount_percentage[${option.value}]" class="form-control" placeholder="{{__('enter_value')}}" required>
                                </td>
                            `;
                            tableBody.appendChild(row);
                        }
                    });
        
                    existingRows.forEach(row => {
                        if (!selectedOptions.some(option => option.value === row.dataset.id)) {
                            row.remove();
                        }
                    });
                });
            });
        
        </script>
    @endpush
@endsection
