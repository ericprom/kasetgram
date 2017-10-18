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
			$api->post('auth/companies', 'App\Api\V1\Controllers\AuthController@companies');
			$api->post('auth/users', 'App\Api\V1\Controllers\AuthController@users');
			$api->post('auth/roles', 'App\Api\V1\Controllers\AuthController@roles');
			$api->post('auth/menus', 'App\Api\V1\Controllers\AuthController@menus');
			$api->post('auth/details', 'App\Api\V1\Controllers\AuthController@details');
			$api->resource('companies', 'App\Api\V1\Controllers\CompanyController');

			$api->post('upload/avatar', 'App\Api\V1\Controllers\UploadController@avatar');

		});
		$api->group(['middleware' => ['auth:api', 'role:super-admin']], function ($api) {
			$api->resource('companies', 'App\Api\V1\Controllers\CompanyController');
			$api->resource('roles', 'App\Api\V1\Controllers\RoleController');
			$api->resource('permissions', 'App\Api\V1\Controllers\PermissionController');
			$api->resource('users', 'App\Api\V1\Controllers\UserController');
		});
	});

});
