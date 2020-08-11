<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            @can('user_management_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    @can('permission_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('cruds.permission.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('role_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('user_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon">

                            </i>
                            {{ trans('cruds.user.title') }}
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('management_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file nav-icon">

                    </i>
                    File
                </a>
                <ul class="nav-dropdown-items">
                    @can('area_access')
                    <li class="nav-item">
                        <a href="{{ route("areas.index") }}" class="nav-link {{ request()->is('admin/areas') || request()->is('admin/areas/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                            {{ trans('cruds.areaManagement.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('client_access')
                    <li class="nav-item">
                        <a href="{{ route("client.index") }}" class="nav-link {{ request()->is('client') || request()->is('client/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Clients
                        </a>
                    </li>
                    @endcan
                    @can('cost_center_access')
                    <li class="nav-item">
                        <a href="{{ route("cost-centers.index") }}" class="nav-link {{ request()->is('cost-centers') || request()->is('cost-centers/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            {{ trans('cruds.costCenters.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('legal_center_access')
                    <li class="nav-item">
                        <a href="{{ route("legal-centers.index") }}" class="nav-link {{ request()->is('legal-centers') || request()->is('legal-centers/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            {{ trans('cruds.legalCenters.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('suppliers_access')
                    <li class="nav-item">
                        <a href="{{ route("suppliers.index") }}" class="nav-link {{ request()->is('suppliers') || request()->is('suppliers/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            {{ trans('cruds.suppliersManagement.title') }}
                        </a>
                    </li>
                    @endcan
                    @can('bank_access')
                    <li class="nav-item">
                        <a href="{{ route("bank.index") }}" class="nav-link {{ request()->is('bank') || request()->is('bank/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Banks
                        </a>
                    </li>
                    @endcan
                    @can('mop_access')
                    <li class="nav-item">
                        <a href="{{ route("mops.index") }}" class="nav-link {{ request()->is('mops') || request()->is('mops/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Modes of Payments
                        </a>
                    </li>
                    @endcan

                    @can('status_access')
                    <li class="nav-item">
                        <a href="{{ route("status.index") }}" class="nav-link {{ request()->is('status') || request()->is('status/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Status
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file nav-icon">

                    </i>
                    Transactions
                </a>
                <ul class="nav-dropdown-items">
                    @can('meter_access')
                    <li class="nav-item">
                        <a href="{{ route("meter.index") }}" class="nav-link {{ request()->is('meter') || request()->is('meter/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                            Meter Readings
                        </a>
                    </li>
                    @endcan   
                    @can('billing_access')
                    <li class="nav-item">
                        <a href="{{ route("billing.index") }}" class="nav-link {{ request()->is('billing') || request()->is('billing/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Bills
                        </a>
                    </li>
                    @endcan  
                    @can('payment_access')
                    <li class="nav-item">
                        <a href="{{ route("payment.index") }}" class="nav-link {{ request()->is('payment') || request()->is('payment/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Payments
                        </a>
                    </li>
                    @endcan  
                </ul>
            </li>
            @can('report_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-file nav-icon">

                    </i>
                    Reports
                </a>
                <ul class="nav-dropdown-items">

                    <li class="nav-item">
                        <a href="{{ route("statement.index") }}" class="nav-link {{ request()->is('statement') || request()->is('statement/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                            Account Statement
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("billing.index") }}" class="nav-link {{ request()->is('billing') || request()->is('billing/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Area Report
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("payment.index") }}" class="nav-link {{ request()->is('payment') || request()->is('payment/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>
                            Reading Sheets
                        </a>
                    </li>

                </ul>
            </li>
            @endcan
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fas fa-cog fa-fw nav-icon">

                    </i>
                    Set-up
                </a>
                <ul class="nav-dropdown-items">
                    @can('settings_access')
                    <li class="nav-item">
                        <a href="{{ route("settings_nbrd.index") }}" class="nav-link {{ request()->is('settings_nbrd') || request()->is('settings_nbrd/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                            Company Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("settings_dpm.index") }}" class="nav-link {{ request()->is('settings_dpm') || request()->is('settings_dpm/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-arrow-circle-right nav-icon"></i>

                            Billing Settings
                        </a>
                    </li>
                    @endcan                   
                </ul>
            </li>
            @endcan


            @can('expense_category_access')
            <li class="nav-item">
                <a href="{{ route("admin.expense-categories.index") }}" class="nav-link {{ request()->is('admin/expense-categories') || request()->is('admin/expense-categories/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-list nav-icon">

                    </i>
                    {{ trans('cruds.expenseCategory.title') }}
                </a>
            </li>
            @endcan
            @can('income_category_access')
            <li class="nav-item">
                <a href="{{ route("admin.income-categories.index") }}" class="nav-link {{ request()->is('admin/income-categories') || request()->is('admin/income-categories/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-list nav-icon">

                    </i>
                    {{ trans('cruds.incomeCategory.title') }}
                </a>
            </li>
            @endcan
            @can('expense_access')
            <li class="nav-item">
                <a href="{{ route("admin.expenses.index") }}" class="nav-link {{ request()->is('admin/expenses') || request()->is('admin/expenses/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-arrow-circle-right nav-icon">

                    </i>
                    {{ trans('cruds.expense.title') }}
                </a>
            </li>
            @endcan
            @can('income_access')
            <li class="nav-item">
                <a href="{{ route("admin.incomes.index") }}" class="nav-link {{ request()->is('admin/incomes') || request()->is('admin/incomes/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-arrow-circle-right nav-icon">

                    </i>
                    {{ trans('cruds.income.title') }}
                </a>
            </li>
            @endcan
            @can('expense_report_access')
            <li class="nav-item">
                <a href="{{ route("admin.expense-reports.index") }}" class="nav-link {{ request()->is('admin/expense-reports') || request()->is('admin/expense-reports/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-chart-line nav-icon">

                    </i>
                    {{ trans('cruds.expenseReport.title') }}
                </a>
            </li>
            @endcan

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>