<div class="sidebar" style="display:block !important;">
    <nav class="sidebar-nav" style="display:block !important;">

        <ul class="nav">
            @can('dashboard_access')
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->is('dashboard') || request()->is('dashboard/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-dashboard nav-icon">

                        </i>
                        DASHBOARD
                    </a>
                </li>
            @endcan
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ strtoupper(trans('cruds.userManagement.title')) }}
                    </a>
                    <ul class="nav-dropdown-items">

                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan


            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file nav-icon">

                    </i>
                    BOREHOLE WATER
                </a>
                <ul class="nav-dropdown-items">

                    @can('client_access')
                        <li class="nav-item">
                            <a href="{{ route('client.index') }}"
                                class="nav-link {{ request()->is('client') || request()->is('client/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('areas.index') }}"
                                class="nav-link {{ request()->is('admin/areas') || request()->is('admin/areas/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                                Locations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('meter_reading_/0000/48') }}"
                                class="nav-link {{ request()->is('meter') || request()->is('meter/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                                Meter Readings
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{ route('billing.index') }}"
                                class="nav-link {{ request()->is('billing') || request()->is('billing/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Bills
                            </a>
                        </li> --}}


                        <li class="nav-item">
                            <a href="{{ route('payment.index') }}"
                                class="nav-link {{ request()->is('payment') || request()->is('payment/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                Payments
                            </a>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a class="nav-link  nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-file nav-icon">

                                </i>
                                BOREHOLE WATER
                            </a>
                            <ul class="nav-dropdown-items">

                                @can('client_access')
                                    <li class="nav-item">
                                        <a href="{{ route('client.index') }}"
                                            class="nav-link {{ request()->is('client') || request()->is('client/*') ? 'active' : '' }}">
                                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                            Customers
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('balances') }}"
                                    class="nav-link {{ request()->is('areas') || request()->is('areas/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                                    Balances
                                </a>
                            </li>
                        </ul>
                    @endcan

                <li class="nav-item">
                    <a href="#}" class="nav-link">
                        <i class="fa-fw fas fa-file nav-icon"></i>
                        TENANTS
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('logout-user') }}" class="nav-link">
                        <i class="nav-icon fas fa-fw fa-sign-out-alt">

                        </i>
                        {{ trans('global.logout') }}
                    </a>
                </li>
            </ul>



        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
