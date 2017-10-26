<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
	
	$api->group(['prefix' => 'v1'], function ($api) {
		$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
		$api->post('auth/logout', 'App\Api\V1\Controllers\AuthController@logout');

		$api->group(['middleware' => ['auth:api', 'role:super-admin|admin|user']], function ($api) {

			$api->group(['prefix' => 'datalist'], function ($api) {
				$api->post('menus', 'App\Api\V1\Controllers\DatalistController@menus');
				$api->post('companies', 'App\Api\V1\Controllers\DatalistController@companies');
				$api->post('roles', 'App\Api\V1\Controllers\DatalistController@roles');
				$api->post('expenses', 'App\Api\V1\Controllers\DatalistController@expenses');
				$api->post('payments', 'App\Api\V1\Controllers\DatalistController@payments');
				$api->post('farms', 'App\Api\V1\Controllers\DatalistController@farms');
			});

			$api->post('upload/avatar', 'App\Api\V1\Controllers\UploadController@avatar');
			$api->post('auth/users', 'App\Api\V1\Controllers\AuthController@users');
			$api->post('auth/profile/details', 'App\Api\V1\Controllers\AuthController@getprofile');
			$api->post('auth/profile/update', 'App\Api\V1\Controllers\AuthController@updateprofile');

			$api->group(['prefix' => 'accountants'], function ($api) {
				$api->resource('incomes', 'App\Api\V1\Controllers\Accountants\IncomeController');
				$api->resource('expenses', 'App\Api\V1\Controllers\Accountants\ExpenseController');
			});

			$api->group(['prefix' => 'setting'], function ($api) {
				$api->resource('farms', 'App\Api\V1\Controllers\Settings\FarmController');
			});

		});

		$api->group(['middleware' => ['auth:api', 'role:super-admin|admin']], function ($api) {
			$api->post('auth/company/details', 'App\Api\V1\Controllers\AuthController@getcompany');
			$api->post('auth/company/update', 'App\Api\V1\Controllers\AuthController@updatecompany');
			
			$api->group(['prefix' => 'setting'], function ($api) {
				$api->resource('users', 'App\Api\V1\Controllers\Settings\UserController');
				$api->resource('banks', 'App\Api\V1\Controllers\Settings\BankController');
			});

			$api->group(['prefix' => 'report'], function ($api) {
				$api->get('dashboard/summary', 'App\Api\V1\Controllers\Reports\DashboardController@summary');
				$api->get('incomes/list', 'App\Api\V1\Controllers\Reports\IncomeController@list');
				$api->get('incomes/summary', 'App\Api\V1\Controllers\Reports\IncomeController@summary');
				$api->get('expenses/list', 'App\Api\V1\Controllers\Reports\ExpenseController@list');
				$api->get('expenses/summary', 'App\Api\V1\Controllers\Reports\ExpenseController@summary');
			});

		});

		$api->group(['middleware' => ['auth:api', 'role:super-admin']], function ($api) {

			$api->group(['prefix' => 'system'], function ($api) {
				$api->resource('companies', 'App\Api\V1\Controllers\Systems\CompanyController');
				$api->resource('users', 'App\Api\V1\Controllers\Systems\UserController');
				$api->resource('roles', 'App\Api\V1\Controllers\Systems\RoleController');
				$api->resource('permissions', 'App\Api\V1\Controllers\Systems\PermissionController');
			});
			
		});
	});

});
