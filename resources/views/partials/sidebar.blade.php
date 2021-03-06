@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: 100%">
        <ul class="sidebar-menu">
            @can('change_branch')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span class="title">Lihat Cabang Lain</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach( Session::get('branches') as $branch)
                        <li>
                            <a href="{{ url('/change_branch/' . $branch->id ) }}">
                                <i class="fa fa-tags"></i>
                                <span class="title">
                                    {{ $branch->branch_name }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            @endcan
            
            @can('dashboard_access')
            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/') }}">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">@lang('quickadmin.dashboard')</span>
                </a>
            </li>
            @endcan
            
            @can('customer_access')
            <li class="{{ $request->segment(1) == 'customers' ? 'active' : '' }}">
                <a href="{{ route('customers.index') }}">
                    <i class="fa fa-user"></i>
                    <span class="title">@lang('quickadmin.customer.title')</span>
                </a>
            </li>
            @endcan
            
            @can('vehicle_access')
            <li class="{{ $request->segment(1) == 'vehicles' ? 'active' : '' }}">
                <a href="{{ route('vehicles.index') }}">
                    <i class="fa fa-car"></i>
                    <span class="title">@lang('quickadmin.vehicle.title')</span>
                </a>
            </li>
            @endcan

            <li class="{{ $request->segment(1) == 'antrians' ? 'active' : '' }}">
                <a href="{{ route('antrians.create') }}">
                    <i class="fa fa-list"></i>
                    <span class="title">Antrian</span>
                </a>
            </li>
            
            @can('income_access')
            <li class="{{ $request->segment(1) == 'incomes' ? 'active' : '' }}">
                <a href="{{ route('incomes.index') }}">
                    <i class="fa fa-arrow-circle-right"></i>
                    <span class="title">@lang('quickadmin.income.title')</span>
                </a>
            </li>
            @endcan
            
            @can('expense_access')
            <li class="{{ $request->segment(1) == 'expenses' ? 'active' : '' }}">
                <a href="{{ route('expenses.index') }}">
                    <i class="fa fa-arrow-circle-left"></i>
                    <span class="title">@lang('quickadmin.expense.title')</span>
                </a>
            </li>
            @endcan

            @can('expense_access')
            <li class="{{ $request->segment(2) == 'cashflow' ? 'active' : '' }}">
                <a href="{{ route('monthly_reports.cashflow') }}">
                    <i class="fa fa-list"></i>
                    <span class="title">Cashflow</span>
                </a>
            </li>
            @endcan

            @can('access_trashed')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-trash"></i>
                    <span class="title">Trashed</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(2) == 'customers' ? 'active active-sub' : '' }}">
                        <a href="{{ route('customers.trashed') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">@lang('quickadmin.customer.title')</span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'vehicles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('vehicles.trashed') }}">
                            <i class="fa fa-car"></i>
                            <span class="title">@lang('quickadmin.vehicle.title')</span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'incomes' ? 'active active-sub' : '' }}">
                        <a href="{{ route('incomes.trashed') }}">
                            <i class="fa fa-arrow-circle-right"></i>
                            <span class="title">@lang('quickadmin.income.title')</span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'expenses' ? 'active active-sub' : '' }}">
                        <a href="{{ route('expenses.trashed') }}">
                            <i class="fa fa-arrow-circle-left"></i>
                            <span class="title">@lang('quickadmin.expense.title')</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('monthly_report_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart"></i>
                    <span class="title">Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(2) == 'income_statement' ? 'active active-sub' : '' }}">
                        <a href="{{ route('monthly_reports.incomestatement') }}">
                            <i class="fa fa-line-chart"></i>
                            <span class="title">Income Statement</span>
                        </a>
                    </li>
                    @can('change_branch')
                    <li class="{{ $request->segment(2) == 'all_branches' ? 'active active-sub' : '' }}">
                        <a href="{{ route('monthly_reports.all_branches') }}">
                            <i class="fa fa-line-chart"></i>
                            <span class="title">Semua Cabang</span>
                        </a>
                    </li>
                    @endcan
                    <li class="{{ $request->segment(2) == 'incomes_report' ? 'active active-sub' : '' }}">
                        <a href="{{ route('monthly_reports.incomesreport') }}">
                            <i class="fa fa-line-chart"></i>
                            <span class="title">Penjualan - Excel Export</span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'expense_report' ? 'active active-sub' : '' }}">
                        <a href="{{ route('monthly_reports.expensereport') }}">
                            <i class="fa fa-line-chart"></i>
                            <span class="title">Pengeluaran - Excel Export</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list-alt"></i>
                    <span class="title">Survey</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(1) == 'survey' ? 'active active-sub' : '' }}">
                        <a href="{{ route('survey.index') }}">
                            <i class="fa fa-list-alt"></i>
                            <span class="title">Survey Results</span>
                        </a>
                    </li>
                    @can('change_branch')
                    <li class="{{ $request->segment(1) == 'surveytemplate' ? 'active active-sub' : '' }}">
                        <a href="{{ route('surveytemplate.index') }}">
                            <i class="fa fa-list-alt"></i>
                            <span class="title">Survey Template</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            
            @can('history_access')
            <li class="treeview {{ $request->segment(1) == 'history' ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span class="title">History</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(2) == 'income' ? 'active active-sub' : '' }}">
                        <a href="{{ route('history.income') }}">
                            <i class="fa fa-arrow-circle-right"></i>
                            <span class="title">@lang('quickadmin.income.title')</span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'expense' ? 'active active-sub' : '' }}">
                        <a href="{{ route('history.expense') }}">
                            <i class="fa fa-arrow-circle-left"></i>
                            <span class="title">@lang('quickadmin.expense.title')</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('transfer_access')
            <li class="{{ $request->segment(1) == 'transfers' ? 'active' : '' }}">
                <a href="{{ route('transfers.index') }}">
                    <i class="fa fa-arrows-h"></i>
                    <span class="title">@lang('quickadmin.transfer.title')</span>
                </a>
            </li>
            @endcan
            
            <!-- @can('absensi_access')
            <li class="{{ $request->segment(1) == 'absensis' ? 'active' : '' }}">
                <a href="{{ route('absensis.index') }}">
                    <i class="fa fa-clock-o"></i>
                    <span class="title">@lang('quickadmin.absensi.title')</span>
                </a>
            </li>
            @endcan -->
            
            @can('task_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span class="title">@lang('quickadmin.task-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                @can('task_calendar_access')
                <li class="{{ $request->segment(1) == 'task_calendars' ? 'active active-sub' : '' }}">
                        <a href="{{ route('task_calendars.index') }}">
                            <i class="fa fa-calendar"></i>
                            <span class="title">
                                @lang('quickadmin.task-calendar.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('task_access')
                <li class="{{ $request->segment(1) == 'tasks' ? 'active active-sub' : '' }}">
                        <a href="{{ route('tasks.index') }}">
                            <i class="fa fa-paint-brush"></i>
                            <span class="title">
                                @lang('quickadmin.tasks.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('task_status_access')
                <li class="{{ $request->segment(1) == 'task_statuses' ? 'active active-sub' : '' }}">
                        <a href="{{ route('task_statuses.index') }}">
                            <i class="fa fa-server"></i>
                            <span class="title">
                                @lang('quickadmin.task-statuses.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('task_tag_access')
                <li class="{{ $request->segment(1) == 'task_tags' ? 'active active-sub' : '' }}">
                        <a href="{{ route('task_tags.index') }}">
                            <i class="fa fa-server"></i>
                            <span class="title">
                                @lang('quickadmin.task-tags.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            @can('user_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="title">@lang('quickadmin.user-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                @can('role_access')
                <li class="{{ $request->segment(1) == 'roles' ? 'active active-sub' : '' }}">
                        <a href="{{ route('roles.index') }}">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">
                                @lang('quickadmin.roles.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('user_access')
                <li class="{{ $request->segment(1) == 'users' ? 'active active-sub' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-user"></i>
                            <span class="title">
                                @lang('quickadmin.users.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('user_action_access')
                <li class="{{ $request->segment(1) == 'user_actions' ? 'active active-sub' : '' }}">
                        <a href="{{ route('user_actions.index') }}">
                            <i class="fa fa-th-list"></i>
                            <span class="title">
                                @lang('quickadmin.user-actions.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            @can('setting_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gears"></i>
                    <span class="title">@lang('quickadmin.settings.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                @can('expense_category_access')
                <li class="{{ $request->segment(1) == 'expense_categories' ? 'active active-sub' : '' }}">
                        <a href="{{ route('expense_categories.index') }}">
                            <i class="fa fa-mail-reply"></i>
                            <span class="title">
                                @lang('quickadmin.expense-category.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('income_category_access')
                <li class="{{ $request->segment(1) == 'income_categories' ? 'active active-sub' : '' }}">
                        <a href="{{ route('income_categories.index') }}">
                            <i class="fa fa-mail-forward"></i>
                            <span class="title">
                                @lang('quickadmin.income-category.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('branch_access')
                <li class="{{ $request->segment(1) == 'branches' ? 'active active-sub' : '' }}">
                        <a href="{{ route('branches.index') }}">
                            <i class="fa fa-home"></i>
                            <span class="title">
                                @lang('quickadmin.branch.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('account_access')
                <li class="{{ $request->segment(1) == 'accounts' ? 'active active-sub' : '' }}">
                        <a href="{{ route('accounts.index') }}">
                            <i class="fa fa-bank"></i>
                            <span class="title">
                                @lang('quickadmin.account.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('employee_access')
                <li class="{{ $request->segment(1) == 'employees' ? 'active active-sub' : '' }}">
                        <a href="{{ route('employees.index') }}">
                            <i class="fa fa-slideshare"></i>
                            <span class="title">
                                @lang('quickadmin.employees.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            @can('product_management_access')
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="title">@lang('quickadmin.product-management.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                @can('category_access')
                <li class="{{ $request->segment(1) == 'categories' ? 'active active-sub' : '' }}">
                        <a href="{{ route('categories.index') }}">
                            <i class="fa fa-folder"></i>
                            <span class="title">
                                @lang('quickadmin.categories.title')
                            </span>
                        </a>
                </li>
                @endcan
                @can('tag_access')
                <li class="{{ $request->segment(1) == 'tags' ? 'active active-sub' : '' }}">
                        <a href="{{ route('tags.index') }}">
                            <i class="fa fa-tags"></i>
                            <span class="title">
                                @lang('quickadmin.tags.title')
                            </span>
                        </a>
                    </li>
                @endcan
                @can('product_access')
                <li class="{{ $request->segment(1) == 'products' ? 'active active-sub' : '' }}">
                        <a href="{{ route('products.index') }}">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="title">
                                @lang('quickadmin.products.title')
                            </span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
            @endcan
            <li>
                <a href="{{ url('/refresh') }}">
                    <i class="fa fa-arrows-h"></i>
                    <span class="title">Refresh Data</span>
                </a>
            </li>
            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('quickadmin.logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('quickadmin.logout')</button>
{!! Form::close() !!}

<aside class="control-sidebar control-sidebar-dark">
<!-- Content of the sidebar goes here -->
<section class="sidebar" style="height: 100%">
    <ul class="sidebar-menu">
        <li>
            <a href="#" style="text-align:center">
                <i class="fa fa-car"></i> <span class="title">{{ Session::get('antrian_mobil') }}</span> &nbsp &nbsp
                <i class="fa fa-motorcycle"></i> <span class="title">{{ Session::get('antrian_motor') }}</span>
            </a>
        </li>
        @foreach( Session::get('antrian') as $antrian)
        <li>
            <a href="#">
                <i class="fa {{strtoupper($antrian->type) == 'MOBIL' ? 'fa-car' : 'fa-motorcycle' }}" onclick="GetAntrianData({{$antrian}})"></i>
                <span class="title" onclick="GetAntrianData({{$antrian}})">
                    {{strtoupper($antrian->license_plate)}} {{strtoupper($antrian->model)}} {{strtoupper($antrian->color)}} {{substr($antrian->arrival_time, -8, -3)}}
                </span>
                <!-- <span class="glyphicon glyphicon-trash pull-right" style="color:red"> -->
                    {!! Form::open(array(
                        'style' => 'display: inline-block;',
                        'method' => 'DELETE',
                        'onsubmit' => "return confirm('". 'Hapus ' .$antrian->license_plate . ' dari antrian?'. "');",
                        'class' => 'pull-right',
                        'route' => ['antrians.destroy', $antrian->id])) !!}
                    {!! Form::button('<span class="glyphicon glyphicon-trash pull-right" style="color:red"></span>', array('type'=>'submit' ,'class' => 'btn btn-xs', 'style' => 'background-color: Transparent;')) !!}
                    {!! Form::close() !!}
                <!-- </span> -->
                <button class="btn btn-xs pull-right" data-toggle="modal" data-target="#editAntrianForm" data-route="{{route('antrians.update',$antrian->id)}}" data-antrian="{{$antrian}}" style="background-color: transparent;">
                    <span class="glyphicon glyphicon-pencil pull-right"></span>
                </button>
            </a>

        </li>
        @endforeach
        
        <button type="button" class="btn btn-success" style="margin-left: 15px" data-toggle="modal" data-target="#antrianForm">
            +Antrian
        </button>    
        
    </ul>

</section>
</aside>
<!-- The sidebar's background -->
<!-- This div must placed right after the sidebar for it to work-->
<div class="control-sidebar-bg"></div>