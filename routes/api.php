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

		$api->group(['middleware' => ['auth:api']], function ($api) {
			$api->post('upload/avatar', 'App\Api\V1\Controllers\UploadController@avatar');
			$api->post('auth/companies', 'App\Api\V1\Controllers\AuthController@companies');
			$api->post('auth/users', 'App\Api\V1\Controllers\AuthController@users');
			$api->post('auth/roles', 'App\Api\V1\Controllers\AuthController@roles');
			$api->post('auth/menus', 'App\Api\V1\Controllers\AuthController@menus');
			$api->post('auth/profile/details', 'App\Api\V1\Controllers\AuthController@getprofile');
			$api->post('auth/profile/update', 'App\Api\V1\Controllers\AuthController@updateprofile');
			$api->resource('accountants/ledgers', 'App\Api\V1\Controllers\Accountants\LedgerController');
			$api->resource('setting/cars', 'App\Api\V1\Controllers\Settings\CarController');
			$api->resource('setting/types', 'App\Api\V1\Controllers\Settings\TypeController');
			$api->resource('setting/services', 'App\Api\V1\Controllers\Settings\ServiceController');
			$api->resource('setting/insurance/companies', 'App\Api\V1\Controllers\Settings\InsuranceCompanyController');
			$api->resource('setting/codes', 'App\Api\V1\Controllers\Settings\CodeController');
			$api->resource('setting/expenses', 'App\Api\V1\Controllers\Settings\ExpenseController');
		});
		$api->group(['middleware' => ['auth:api', 'role:super-admin|admin']], function ($api) {
			$api->post('auth/company/details', 'App\Api\V1\Controllers\AuthController@getcompany');
			$api->post('auth/company/update', 'App\Api\V1\Controllers\AuthController@updatecompany');
			$api->resource('setting/users', 'App\Api\V1\Controllers\Settings\UserController');
			$api->resource('setting/banks', 'App\Api\V1\Controllers\Settings\BankController');
		});
		$api->group(['middleware' => ['auth:api', 'role:super-admin']], function ($api) {
			$api->resource('system/companies', 'App\Api\V1\Controllers\Systems\CompanyController');
			$api->resource('system/users', 'App\Api\V1\Controllers\Systems\UserController');
			$api->resource('system/roles', 'App\Api\V1\Controllers\Systems\RoleController');
			$api->resource('system/permissions', 'App\Api\V1\Controllers\Systems\PermissionController');
		});
	});

});
