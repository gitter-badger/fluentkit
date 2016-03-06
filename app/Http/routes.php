<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {


    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/test', function(\Illuminate\Http\Request $request){

       event(new \App\Events\User\Notification($request->user(), 'a message', 3000));
    });

    // Auth
    Route::group(['namespace' => '\Auth'], function() {

        // Login
        Route::get('login/{provider?}', ['as' => 'login', 'uses' => 'AuthController@getLogin'])
            ->where(['provider' => '(google|facebook|twitter)']);

        Route::get('login/{provider?}/callback', ['as' => 'login.social.callback', 'uses' => 'AuthController@getLoginCallback'])
            ->where(['provider' => '(google|facebook|twitter)']);

        Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);

        // Logout
        Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

        // Registration routes...
        Route::get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
        Route::post('register', ['as' => 'register.post', 'uses' => 'AuthController@postRegister']);

        // Password reset link request routes...
        Route::get('forgot-password', ['as' => 'forgot_password', 'uses' => 'AuthController@getForgotPassword']);
        Route::post('forgot-password', ['as' => 'forgot_password.post', 'uses' => 'AuthController@postForgotPassword']);

        // Password reset routes...
        Route::get('reset-password/{token}', ['as' => 'reset_password', 'uses' => 'AuthController@getResetPassword']);
        Route::post('reset-password', ['as' => 'reset_password.post', 'uses' => 'AuthController@postResetPassword']);

    });


    // Admin
    Route::group(['namespace' => '\Admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {

        // Dashboard
        Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@getIndex']);

        // Users
        Route::get('/users', ['as' => 'users', 'uses' => 'UsersController@getIndex']);
        Route::get('/users/{id}', ['as' => 'users.edit', 'uses' => 'UsersController@getEdit']);

        // Roles
        Route::get('/roles', ['as' => 'roles', 'uses' => 'RolesController@getIndex']);
        Route::get('/roles/{id}', ['as' => 'roles.edit', 'uses' => 'RolesController@getEdit']);

        // Settings
        Route::get('/settings', ['as' => 'settings', 'uses' => 'SettingsController@getIndex']);
        Route::post('/settings', ['as' => 'settings.post', 'uses' => 'SettingsController@postIndex']);

    });


});


// API
Route::group(['middleware' => ['api'], 'namespace' => '\Api', 'prefix' => 'api', 'as' => 'api.'], function () {

    // Roles
    Route::get('/roles', ['middleware' => 'auth:api', 'as' => 'roles', 'uses' => 'RolesController@getIndex']);
    Route::post('/roles', ['middleware' => 'auth:api', 'as' => 'roles.create', 'uses' => 'RolesController@postCreate']);
    Route::get('/roles/{id}', ['middleware' => 'auth:api', 'as' => 'roles.show', 'uses' => 'RolesController@getShow']);
    Route::patch('/roles/{id}', ['middleware' => 'auth:api', 'as' => 'roles.update', 'uses' => 'RolesController@patchUpdate']);
    Route::delete('/roles/{id}', ['middleware' => 'auth:api', 'as' => 'roles.destroy', 'uses' => 'RolesController@deleteDestroy']);
    Route::patch('/roles/{id}/permissions', ['middleware' => 'auth:api', 'as' => 'roles.permissions.update', 'uses' => 'RolesController@patchPermissionsUpdate']);
    Route::put('/roles/{id}/permissions', ['middleware' => 'auth:api', 'as' => 'roles.permissions.set', 'uses' => 'RolesController@putPermissionsUpdate']);
    Route::delete('/roles/{id}/permissions', ['middleware' => 'auth:api', 'as' => 'roles.permissions.destroy.all', 'uses' => 'RolesController@deletePermissionsDestroyAll']);
    Route::delete('/roles/{id}/permissions/{permissionid}', ['middleware' => 'auth:api', 'as' => 'roles.permissions.destroy', 'uses' => 'RolesController@deletePermissionsDestroy']);


    // Users
    Route::get('/users', ['middleware' => 'auth:api', 'as' => 'users', 'uses' => 'UsersController@getIndex']);
    Route::post('/users', ['middleware' => 'auth:api', 'as' => 'users.create', 'uses' => 'UsersController@postCreate']);
    Route::get('/users/{id}', ['middleware' => 'auth:api', 'as' => 'users.show', 'uses' => 'UsersController@getShow']);
    Route::patch('/users/{id}', ['middleware' => 'auth:api', 'as' => 'users.update', 'uses' => 'UsersController@patchUpdate']);
    Route::delete('/users/{id}', ['middleware' => 'auth:api', 'as' => 'users.destroy', 'uses' => 'UsersController@deleteDestroy']);
    Route::patch('/users/{id}/roles', ['middleware' => 'auth:api', 'as' => 'users.roles.update', 'uses' => 'UsersController@patchRolesUpdate']);
    Route::put('/users/{id}/roles', ['middleware' => 'auth:api', 'as' => 'users.roles.set', 'uses' => 'UsersController@putRolesUpdate']);
    Route::delete('/users/{id}/roles', ['middleware' => 'auth:api', 'as' => 'users.roles.destroy.all', 'uses' => 'UsersController@deleteRolesDestroyAll']);
    Route::delete('/users/{id}/roles/{roleid}', ['middleware' => 'auth:api', 'as' => 'users.roles.destroy', 'uses' => 'UsersController@deleteRolesDestroy']);

});