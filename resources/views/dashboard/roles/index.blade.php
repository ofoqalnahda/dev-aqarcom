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
                                <div class="card-body p-1 search-bar">
                                    <div class="col-md-8">
                                        <form class="search-form" action="{{ route('dashboard.roles.index') }}">
                                            <input type="text" name="search" value="{{ request()->search }}"
                                                class="form-control-sm" />
                                            <button class="btn btn-sm btn-primary m-1">@lang('search')</button>
                                        </form>
                                    </div>
                                    @can('roles-create')
                                    <div class="col-md-4 text-right">
                                        <a href="{{ route('dashboard.roles.create') }}"
                                            class="btn-sm btn-primary">@lang('add')</a>
                                    </div>
                                    @endcan
                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Company Table Card -->
                    <div class="col-lg-12 col-12">
                        <div class="card card-company-table">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('name')</th>

                                                <th>@lang('control')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                                <?php
                                                // dd($user);
                                                ?>
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>
                                                        <div class="d-flex">
                                                            <span>{{ $role->name }}</span>
                                                        </div>
                                                    </td>


                                                    <td>
                                                        @if ($role->name != 'super_admin')
                                                            <div class="d-flex align-items-center">
                                                                @can('roles-edit')
                                                                <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                                                    class="btn btn-sm btn-primary m-1">@lang('edit')</a>
                                                               @endcan
                                                               @can('roles-destroy')
                                                                    <form
                                                                    action="{{ route('dashboard.roles.destroy', $role->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger m-1">@lang('delete')</button>
                                                                </form>
                                                                @endcan
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $roles->appends(request()->query())->links() }}
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
