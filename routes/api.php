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
			$api->post('auth/company/details', 'App\Api\V1\Controllers\AuthController@getcompany');
			$api->post('auth/company/update', 'App\Api\V1\Controllers\AuthController@updatecompany');
			$api->post('auth/profile/details', 'App\Api\V1\Controllers\AuthController@getprofile');
			$api->post('auth/profile/update', 'App\Api\V1\Controllers\AuthController@updateprofile');
		});
		$api->group(['middleware' => ['auth:api', 'role:super-admin|admin']], function ($api) {
			$api->resource('setting/users', 'App\Api\V1\Controllers\SettingUserController');
		});
		$api->group(['middleware' => ['auth:api', 'role:super-admin']], function ($api) {
			$api->resource('system/companies', 'App\Api\V1\Controllers\SystemCompanyController');
			$api->resource('system/users', 'App\Api\V1\Controllers\SystemUserController');
			$api->resource('system/roles', 'App\Api\V1\Controllers\SystemRoleController');
			$api->resource('system/permissions', 'App\Api\V1\Controllers\SystemPermissionController');
		});
	});

});
