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

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

$this->get('s/{branch_id}/{income_id}','SurveyController@create')->name('survey.create');
$this->post('s/store', 'SurveyController@store')->name('survey.store');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index');
    Route::get('/monthly_reports/income_statement', 'HomeController@viewIncomeStatement')->name('monthly_reports.incomestatement');
    Route::get('/monthly_reports/all_branches', 'HomeController@viewAllBranches')->name('monthly_reports.all_branches');
    Route::get('/loadAllBranchesRevenue', 'HomeController@loadAllBranchesRevenue')->name('loadAllBranchesRevenue');
    Route::get('/loadAllBranchesExpenses', 'HomeController@loadAllBranchesExpenses')->name('loadAllBranchesExpenses');
    Route::get('/monthly_reports/cashflow', 'HomeController@viewCashFlow')->name('monthly_reports.cashflow');
    Route::get('/loadCashFlowData', 'HomeController@loadCashFlowData')->name('loadCashFlowData');
    Route::get('/history/income', ['uses' => 'HistoryController@income', 'as' => 'history.income']);
    Route::get('/history/expense', ['uses' => 'HistoryController@expense', 'as' => 'history.expense']);
    Route::get('/change_branch/{branch_id}', 'ChangeBranchController@index');
    Route::resource('surveytemplate', 'SurveyTemplateController');
    Route::resource('roles', 'RolesController');
    Route::resource('antrians', 'AntrianController');
    Route::post('roles_mass_destroy', ['uses' => 'RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'UsersController');
    Route::post('users_mass_destroy', ['uses' => 'UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    Route::resource('expense_categories', 'ExpenseCategoriesController');
    Route::post('expense_categories_mass_destroy', ['uses' => 'ExpenseCategoriesController@massDestroy', 'as' => 'expense_categories.mass_destroy']);
    Route::resource('income_categories', 'IncomeCategoriesController');
    Route::post('income_categories_mass_destroy', ['uses' => 'IncomeCategoriesController@massDestroy', 'as' => 'income_categories.mass_destroy']);
    Route::resource('incomes', 'IncomesController');
    Route::get('/loadVehiclesData', 'IncomesController@loadVehiclesData')->name('loadVehiclesData');
    Route::get('/loadDashboardData', 'HomeController@loadDashboardData')->name('loadDashboardData');
    Route::get('/loadIncomeStatementData', 'HomeController@loadIncomeStatementData')->name('loadIncomeStatementData');
    Route::get('/loadIncomeDataByDate', 'HomeController@loadIncomeDataByDate')->name('loadIncomeDataByDate');
    Route::get('/loadVehiclesDataByHour', 'HomeController@loadVehiclesDataByHour')->name('loadVehiclesDataByHour');
    Route::get('/loadVehiclesDataByDate', 'HomeController@loadVehiclesDataByDate')->name('loadVehiclesDataByDate');
    Route::get('/loadVehiclesDataByMonth', 'HomeController@loadVehiclesDataByMonth')->name('loadVehiclesDataByMonth');
    Route::get('/loadAllBranchesIncomeByDate', 'HomeController@loadAllBranchesIncomeByDate')->name('loadAllBranchesIncomeByDate');
    Route::get('/loadExpenseDataByCategory', 'HomeController@loadExpenseDataByCategory')->name('loadExpenseDataByCategory');
    Route::get('/loadExpensesData', 'ExpensesController@loadExpensesData')->name('loadExpensesData');
    Route::get('/loadTrashedVehiclesDataTables', 'VehiclesController@loadTrashedVehiclesDataTables')->name('loadTrashedVehiclesDataTables');
    Route::get('/loadTrashedIncomesData', 'IncomesController@loadTrashedIncomesData')->name('loadTrashedIncomesData');
    Route::get('/loadTrashedExpensesData', 'ExpensesController@loadTrashedExpensesData')->name('loadTrashedExpensesData');
    Route::get('/loadVehiclesDataTables', 'VehiclesController@loadVehiclesDataTables')->name('loadVehiclesDataTables');
    Route::get('/loadVehiclesSalesData/{id}', 'VehiclesController@loadVehiclesSalesData')->name('loadVehiclesSalesData');
    Route::get('/loadIncomesData', 'IncomesController@loadIncomesData')->name('loadIncomesData');
    Route::get('/loadFullIncomesData', 'HistoryController@loadFullIncomesData')->name('loadFullIncomesData');
    Route::get('/loadFullExpensesData', 'HistoryController@loadFullExpensesData')->name('loadFullExpensesData');
    Route::get('/loadCustomersData', 'CustomersController@loadCustomersData')->name('loadCustomersData');
    Route::get('/loadTrashedCustomersData', 'CustomersController@loadTrashedCustomersData')->name('loadTrashedCustomersData');
    Route::post('incomes_mass_destroy', ['uses' => 'IncomesController@massDestroy', 'as' => 'incomes.mass_destroy']);
    Route::resource('expenses', 'ExpensesController');
    Route::post('expenses_mass_destroy', ['uses' => 'ExpensesController@massDestroy', 'as' => 'expenses.mass_destroy']);
    Route::get('/monthly_report/incomes_report',['uses'=>'MonthlyReportsController@incomesreport','as'=>'monthly_reports.incomesreport']);
    Route::get('/monthly_report/expense_report',['uses'=>'MonthlyReportsController@expensereport','as'=>'monthly_reports.expensereport']);
    Route::resource('monthly_reports', 'MonthlyReportsController');

    Route::resource('branches', 'BranchesController');
    Route::post('branches_mass_destroy', ['uses' => 'BranchesController@massDestroy', 'as' => 'branches.mass_destroy']);
    Route::get('customers/createFull/', ['uses' => 'CustomersController@createFull', 'as' => 'customers.createFull']);
    Route::post('customers/storeFull/', ['uses' => 'CustomersController@storeFull', 'as' => 'customers.storeFull']);
    Route::resource('customers', 'CustomersController');
    Route::post('customers_mass_destroy', ['uses' => 'CustomersController@massDestroy', 'as' => 'customers.mass_destroy']);
    Route::get('vehicles/createIncome/{id}', ['uses' => 'VehiclesController@createIncome', 'as' => 'vehicles.createIncome']);

    Route::delete('trashed/vehicles/permanentdestroy/{id}', ['uses' => 'VehiclesController@permanentdestroy', 'as' => 'vehicles.permanentdestroy']);
    Route::post('trashed/vehicles/destroyall/', ['uses' => 'VehiclesController@permanentdestroyall', 'as' => 'vehicles.permanentdestroyall']);
    Route::post('trashed/vehicles/restore/{id}', ['uses' => 'VehiclesController@restore', 'as' => 'vehicles.restore']);
    Route::get('trashed/vehicles/', ['uses' => 'VehiclesController@trashed', 'as' => 'vehicles.trashed']);

    Route::get('trashed/incomes/', ['uses' => 'IncomesController@trashed', 'as' => 'incomes.trashed']);
    Route::delete('trashed/incomes/permanentdestroy/{id}', ['uses' => 'IncomesController@permanentdestroy', 'as' => 'incomes.permanentdestroy']);
    Route::post('trashed/incomes/destroyall/', ['uses' => 'IncomesController@permanentdestroyall', 'as' => 'incomes.permanentdestroyall']);
    Route::post('trashed/incomes/restore/{id}', ['uses' => 'IncomesController@restore', 'as' => 'incomes.restore']);

    Route::get('trashed/customers/', ['uses' => 'CustomersController@trashed', 'as' => 'customers.trashed']);
    Route::delete('trashed/customers/permanentdestroy/{id}', ['uses' => 'CustomersController@permanentdestroy', 'as' => 'customers.permanentdestroy']);
    Route::post('trashed/customers/destroyall/', ['uses' => 'CustomersController@permanentdestroyall', 'as' => 'customers.permanentdestroyall']);
    Route::post('trashed/customers/restore/{id}', ['uses' => 'CustomersController@restore', 'as' => 'customers.restore']);

    Route::get('trashed/expenses/', ['uses' => 'ExpensesController@trashed', 'as' => 'expenses.trashed']);
    Route::delete('trashed/expenses/permanentdestroy/{id}', ['uses' => 'ExpensesController@permanentdestroy', 'as' => 'expenses.permanentdestroy']);
    Route::post('trashed/expenses/destroyall/', ['uses' => 'ExpensesController@permanentdestroyall', 'as' => 'expenses.permanentdestroyall']);
    Route::post('trashed/expenses/restore/{id}', ['uses' => 'ExpensesController@restore', 'as' => 'expenses.restore']);

    Route::get('vehicles/createFull/', ['uses' => 'VehiclesController@createFull', 'as' => 'vehicles.createFull']);
    Route::post('vehicles/storeFull/', ['uses' => 'VehiclesController@storeFull', 'as' => 'vehicles.storeFull']);
    Route::resource('vehicles', 'VehiclesController');
    Route::post('vehicles_mass_destroy', ['uses' => 'VehiclesController@massDestroy', 'as' => 'vehicles.mass_destroy']);
    Route::resource('task_calendars', 'TaskCalendarsController');
    Route::resource('accounts', 'AccountsController');
    Route::post('accounts_mass_destroy', ['uses' => 'AccountsController@massDestroy', 'as' => 'accounts.mass_destroy']);
    Route::resource('transfers', 'TransfersController');
    Route::get('/refresh', 'TransfersController@refresh');
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
