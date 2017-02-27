<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

        Route::resource('roles', 'RolesController');

        Route::resource('users', 'UsersController');

        Route::resource('expense_categories', 'ExpenseCategoriesController');

        Route::resource('income_categories', 'IncomeCategoriesController');

        Route::resource('incomes', 'IncomesController');

        Route::resource('expenses', 'ExpensesController');

        Route::resource('branches', 'BranchesController');

        Route::resource('customers', 'CustomersController');

        Route::resource('vehicles', 'VehiclesController');

        Route::resource('accounts', 'AccountsController');

        Route::resource('transfers', 'TransfersController');

        Route::resource('task_statuses', 'TaskStatusesController');

        Route::resource('task_tags', 'TaskTagsController');

        Route::resource('tasks', 'TasksController');

        Route::resource('categories', 'CategoriesController');

        Route::resource('tags', 'TagsController');

        Route::resource('products', 'ProductsController');

        Route::resource('absensis', 'AbsensisController');

});
