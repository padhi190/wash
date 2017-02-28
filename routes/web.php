<?php
Route::get('/', function () {
    return redirect('/home');
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('auth.register');
$this->post('register', 'Auth\RegisterController@register')->name('auth.register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('change_branch/{branch_id}', 'ChangeBranchController@index');
    Route::resource('roles', 'RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'UsersController');
    Route::post('users_mass_destroy', ['uses' => 'UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('expense_categories', 'ExpenseCategoriesController');
    Route::post('expense_categories_mass_destroy', ['uses' => 'ExpenseCategoriesController@massDestroy', 'as' => 'expense_categories.mass_destroy']);
    Route::resource('income_categories', 'IncomeCategoriesController');
    Route::post('income_categories_mass_destroy', ['uses' => 'IncomeCategoriesController@massDestroy', 'as' => 'income_categories.mass_destroy']);
    Route::resource('incomes', 'IncomesController');
    Route::post('incomes_mass_destroy', ['uses' => 'IncomesController@massDestroy', 'as' => 'incomes.mass_destroy']);
    Route::resource('expenses', 'ExpensesController');
    Route::post('expenses_mass_destroy', ['uses' => 'ExpensesController@massDestroy', 'as' => 'expenses.mass_destroy']);
    Route::resource('monthly_reports', 'MonthlyReportsController');
    Route::resource('branches', 'BranchesController');
    Route::post('branches_mass_destroy', ['uses' => 'BranchesController@massDestroy', 'as' => 'branches.mass_destroy']);
    Route::resource('customers', 'CustomersController');
    Route::post('customers_mass_destroy', ['uses' => 'CustomersController@massDestroy', 'as' => 'customers.mass_destroy']);
    Route::resource('vehicles', 'VehiclesController');
    Route::post('vehicles_mass_destroy', ['uses' => 'VehiclesController@massDestroy', 'as' => 'vehicles.mass_destroy']);
    Route::resource('task_calendars', 'TaskCalendarsController');
    Route::resource('accounts', 'AccountsController');
    Route::post('accounts_mass_destroy', ['uses' => 'AccountsController@massDestroy', 'as' => 'accounts.mass_destroy']);
    Route::resource('transfers', 'TransfersController');
    Route::post('transfers_mass_destroy', ['uses' => 'TransfersController@massDestroy', 'as' => 'transfers.mass_destroy']);
    Route::resource('task_calendars', 'TaskCalendarsController');
    Route::resource('task_statuses', 'TaskStatusesController');
    Route::post('task_statuses_mass_destroy', ['uses' => 'TaskStatusesController@massDestroy', 'as' => 'task_statuses.mass_destroy']);
    Route::resource('task_tags', 'TaskTagsController');
    Route::post('task_tags_mass_destroy', ['uses' => 'TaskTagsController@massDestroy', 'as' => 'task_tags.mass_destroy']);
    Route::resource('tasks', 'TasksController');
    Route::post('tasks_mass_destroy', ['uses' => 'TasksController@massDestroy', 'as' => 'tasks.mass_destroy']);
    Route::resource('task_calendars', 'TaskCalendarsController');
    Route::resource('employees', 'EmployeesController');
    Route::post('employees_mass_destroy', ['uses' => 'EmployeesController@massDestroy', 'as' => 'employees.mass_destroy']);
    Route::resource('categories', 'CategoriesController');
    Route::post('categories_mass_destroy', ['uses' => 'CategoriesController@massDestroy', 'as' => 'categories.mass_destroy']);
    Route::resource('tags', 'TagsController');
    Route::post('tags_mass_destroy', ['uses' => 'TagsController@massDestroy', 'as' => 'tags.mass_destroy']);
    Route::resource('products', 'ProductsController');
    Route::post('products_mass_destroy', ['uses' => 'ProductsController@massDestroy', 'as' => 'products.mass_destroy']);
    Route::resource('absensis', 'AbsensisController');
    Route::post('absensis_mass_destroy', ['uses' => 'AbsensisController@massDestroy', 'as' => 'absensis.mass_destroy']);
    Route::resource('user_actions', 'UserActionsController');
});
