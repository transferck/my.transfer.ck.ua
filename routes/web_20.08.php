<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/


Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});

// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function () {
    Route::get('/', 'UserController@index')->name('index');
});
Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep', 'checkblocked']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'ProfilesController@userProfileAvatar',
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);

    //Route::get('orders/deleted', 'OrdersManagementController@deletedList');

    Route::resource('/orders/deleted', 'OrderDeleteController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('orders', 'OrdersManagementController', [
        'names' => [
            'index'  	 => 'orders',
			'create'  	 => 'order.store_pr',
            'destroy'	 => 'order.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
	Route::post('create', 'OrdersManagementController@store_pr')->name('order.store_pr');
	Route::get('orders-all', 'OrdersManagementController@orders_all')->name('orders-all');
    Route::get('allSearchRange', 'OrdersManagementController@allSearchRange')->name('allSearchRange');
	Route::get('orders/{id}/reservation', 'OrdersManagementController@reservation')->name('reservation');
	Route::get('orders/{id}/cancel', 'OrdersManagementController@cancelOrder')->name('cancelOrder');
	Route::put('updateArrival/{id}', 'OrdersManagementController@updateArrival')->name('order.updateArrival');
    Route::delete('order/{id}', 'OrdersManagementController@destroy');
	Route::post('search-orders', 'OrdersManagementController@search')->name('search-orders');
	Route::get('orders-stats', 'OrdersStatsController@index');
	Route::get('charts', 'OrdersStatsController@getChartsData');
	Route::get('partners', 'PagesController@partners')->name('partners');
	Route::get('support', 'PagesController@support')->name('support');	
	Route::get('agents', 'OrderAgentController@agents')->name('agents');
	Route::get('agents-all', 'OrderAgentController@agentAll')->name('agentAll');


    Route::get('orders-all/api', 'OrdersManagementController@allOrdersApi')->name('orders-api.all');
    Route::get('orders-index/api', 'OrdersManagementController@ordersApi')->name('orders-api.index');
    Route::get('agents/api', 'OrderAgentController@allAgentsApi')->name('agents-api.all');

});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');	

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);



    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');
});


Route::redirect('/php', '/phpinfo', 301);


Route::get('changeStatus', 'OrderController@changeStatus');