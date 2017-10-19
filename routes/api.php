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
				$api->post('payments', 'App\Api\V1\Controllers\DatalistController@payments');
				$api->post('expenses', 'App\Api\V1\Controllers\DatalistController@expenses');
				$api->post('types', 'App\Api\V1\Controllers\DatalistController@types');
				$api->post('makes', 'App\Api\V1\Controllers\DatalistController@makes');
			});

			$api->post('upload/avatar', 'App\Api\V1\Controllers\UploadController@avatar');
			$api->post('auth/users', 'App\Api\V1\Controllers\AuthController@users');
			$api->post('auth/profile/details', 'App\Api\V1\Controllers\AuthController@getprofile');
			$api->post('auth/profile/update', 'App\Api\V1\Controllers\AuthController@updateprofile');

			$api->group(['prefix' => 'accountants'], function ($api) {
				$api->resource('ledgers', 'App\Api\V1\Controllers\Accountants\LedgerController');
			});

			$api->group(['prefix' => 'setting'], function ($api) {
				$api->resource('cars', 'App\Api\V1\Controllers\Settings\MakeController');
				$api->resource('types', 'App\Api\V1\Controllers\Settings\TypeController');
				$api->resource('insurance/companies', 'App\Api\V1\Controllers\Settings\InsuranceCompanyController');
				$api->resource('codes', 'App\Api\V1\Controllers\Settings\CodeController');
				$api->resource('expenses', 'App\Api\V1\Controllers\Settings\ExpenseController');
			});

		});

		$api->group(['middleware' => ['auth:api', 'role:super-admin|admin']], function ($api) {
			$api->post('auth/company/details', 'App\Api\V1\Controllers\AuthController@getcompany');
			$api->post('auth/company/update', 'App\Api\V1\Controllers\AuthController@updatecompany');
			$api->resource('setting/users', 'App\Api\V1\Controllers\Settings\UserController');
			$api->resource('setting/banks', 'App\Api\V1\Controllers\Settings\BankController');
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
