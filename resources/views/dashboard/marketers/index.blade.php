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
                        @can('marketers-create')
                            <div class="col-lg-12 col-12">
                                <div class="card card-company-table">
                                    <div class="card-body p-1 search-bar">
                                        <a href="{{ route('dashboard.marketers.create') }}"
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
                                                    <th>@lang('email')</th>
                                                    <th>@lang('phone')</th>
                                                    <th>@lang('balance')</th>
                                                    <th>@lang('discount_percentage')</th>
                                                    <th>@lang('commission_percentage')</th>
                                                    <th>@lang('code')</th>
                                                    <th> @lang('coupon_usage') </th>
                                                    <th> @lang('concerned_party') </th>
                                                    <th> @lang('join at') </th>


                                                    <th>@lang('control')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($marketers as $marketer)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a
                                                                    href="{{ route('dashboard.marketers.show', $marketer->id) }}"><span>{{ $marketer->name }}</span></a>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->email }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->phone }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->balance }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->discount_percentage }} ,  {{__($marketer->discount_type)}}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->commission_percentage }}</span>
                                                            </div>
                                                        </td>

                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->code }}</span>
                                                            </div>
                                                        </td>

                                                    
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                class="font-weight-bolder mb-25">{{ $marketer->transactions()->count() }}</span>
                                                            </div>
                                                        </td>
                                                       
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->concerned_party }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $marketer->created_at ? $marketer->created_at->format('Y-m-d h:i A'):'' }}</span>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                @can('marketers-edit')
                                                                    <a href="{{ route('dashboard.marketers.edit', $marketer->id) }}"
                                                                        class="btn-sm btn-info m-1">@lang('edit')</a>
                                                                @endcan
                                                                @can('marketers-draws')
                                                                    <a href="{{ route('dashboard.marketers.draws', $marketer->id) }}"
                                                                        class="btn-sm btn-primary m-1">@lang('actions')</a>
                                                                @endcan
                                                                @can('marketers-clear')
                                                                    @if ($marketer->balance)
                                                                        <a href="{{ route('dashboard.marketers.clear', $marketer->id) }}"
                                                                            class="btn-sm btn-dark m-1">@lang('clear')</a>
                                                                    @endif
                                                                @endcan
                                                                @canany('marketers-destroy')
                                                                    <button data-toggle="modal" data-target="#delete-marketer"
                                                                        data-id="{{ $marketer->id }}" id="delete-btn"
                                                                        class="btn btn-sm btn-danger m-1">@lang('delete')</button>
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
                <div class="modal fade" id="delete-marketer" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">@lang('delete')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="" id="delete-form">
                                    @csrf
                                    @method('delete')
                                    <div class="form-group m-1 ">
                                        <label>@lang('code')</label>
                                        <input class="form-control" type="text" name="code" id="code">
                                        <button type="submit" style="width:100%"
                                            class="btn btn-danger mt-1">@lang('delete')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- dashboard_files Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    @push('scripts')
        <script>
            $(document).on('click', '#delete-btn', function(e) {
                var form_url = "{{ route('dashboard.marketers.destroy', ':id') }}";
                form_url = form_url.replace(':id', $(this).data('id'));
                $('#delete-form').attr('action', form_url);

                var url = "{{ route('dashboard.marketers.sendCode', ':id') }}";
                url = url.replace(':id', $(this).data('id'));

                $.ajax({
                    url: url,
                    method: "get",
                    dataType: 'json',
                    success: function(response) {

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "تم ارسال الكود بنجاح",
                            timeout: 2000,
                            killer: true
                        }).show();

                    },
                    error: function(response) {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "فشل ارسال الكود",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                });

            });

            $(document).on('submit', '#delete-form', function(e) {
                e.preventDefault();
                var form = $(this);
                var code = form.find('#code').val();
                console.log(code);
                console.log(form.attr('action'));

                $.ajax({
                    url: form.attr('action'),
                    method: "delete",
                    dataType: 'json',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'code': code
                    },
                    success: function(response) {
                        location.reload()
                    },
                    error: function(response) {
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: "كود التحقق غير صحيح",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                });

            });
        </script>
    @endpush
@endsection
