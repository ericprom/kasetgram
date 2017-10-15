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
		$api->post('auth/register', 'App\Api\V1\Controllers\AuthController@register');

		$api->group(['middleware' => ['auth:api']], function ($api) {
			$api->post('auth/menus', 'App\Api\V1\Controllers\AuthController@menus');
			$api->post('auth/details', 'App\Api\V1\Controllers\AuthController@details');
		});
	});

});
