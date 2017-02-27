<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1, 3]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1, 3]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1, 3]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1, 3]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Settings
        Gate::define('setting_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Expense category
        Gate::define('expense_category_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('expense_category_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('expense_category_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('expense_category_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('expense_category_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Income category
        Gate::define('income_category_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('income_category_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('income_category_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('income_category_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('income_category_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Income
        Gate::define('income_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('income_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('income_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('income_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('income_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Expense
        Gate::define('expense_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('expense_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('expense_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('expense_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('expense_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Monthly report
        Gate::define('monthly_report_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Branch
        Gate::define('branch_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('branch_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('branch_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('branch_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('branch_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Customer
        Gate::define('customer_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('customer_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('customer_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('customer_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('customer_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Vehicle
        Gate::define('vehicle_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('vehicle_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('vehicle_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('vehicle_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('vehicle_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Task calendar
        Gate::define('task_calendar_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Account
        Gate::define('account_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('account_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('account_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('account_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('account_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Transfer
        Gate::define('transfer_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('transfer_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('transfer_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('transfer_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('transfer_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Task calendar
        Gate::define('task_calendar_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Task management
        Gate::define('task_management_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        // Auth gates for: Task statuses
        Gate::define('task_status_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('task_status_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('task_status_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('task_status_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('task_status_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Task tags
        Gate::define('task_tag_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('task_tag_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('task_tag_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('task_tag_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('task_tag_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Tasks
        Gate::define('task_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('task_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('task_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('task_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('task_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Task calendar
        Gate::define('task_calendar_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Employees
        Gate::define('employee_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('employee_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('employee_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('employee_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('employee_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Product management
        Gate::define('product_management_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Categories
        Gate::define('category_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('category_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('category_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('category_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('category_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Tags
        Gate::define('tag_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('tag_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('tag_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('tag_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('tag_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Products
        Gate::define('product_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('product_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('product_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('product_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('product_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Absensi
        Gate::define('absensi_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('absensi_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('absensi_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('absensi_view', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
        Gate::define('absensi_delete', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: User actions
        Gate::define('user_action_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

    }
}
