<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api/v1'], function(){
    Route::get('products/{id}/tags', 'Api\TagsController@index');
    Route::resource('products','Api\ProductsController');
    Route::resource('categories','Api\CategoriesController');
    Route::get('categories/{id}/children', 'Api\CategoriesController@children');
    Route::resource('tags','Api\TagsController',['only' => ['index','show']]);

});
Route::get('/', [
    'as'   => 'home',
    'uses' => 'PagesController@Home'
]);
Route::get('/home', [
    'as'   => 'home',
    'uses' => 'PagesController@Home'
]);
Route::get('/contact', [
    'as'   => 'contact_path',
    'uses' => 'PagesController@Contact'
]);
Route::post('contact', [
    'as'   => 'contact.store',
    'uses' => 'PagesController@postContact'
]);
Route::get('/about', [
    'as'   => 'about_path',
    'uses' => 'PagesController@About'
]);
Route::get('/terms', [
    'as'   => 'terms_path',
    'uses' => 'PagesController@Terms'
]);
Route::get('/terms-products', [
    'as'   => 'termsProducts_path',
    'uses' => 'PagesController@TermsProducts'
]);
Route::get('/terms-username', [
    'as'   => 'termsUsername_path',
    'uses' => 'PagesController@TermsUsername'
]);
Route::get('/terms-privacy', [
    'as'   => 'termsPrivacy_path',
    'uses' => 'PagesController@TermsPrivacy'
]);
Route::get('/tips', [
    'as'   => 'tips_path',
    'uses' => 'PagesController@Tips'
]);
Route::get('/fake-email', [
    'as'   => 'fakeEmail_path',
    'uses' => 'PagesController@FakeEmail'
]);
Route::get('/forget-password', [
    'as'   => 'forgetPassword_path',
    'uses' => 'PagesController@ForgetPassword'
]);
Route::get('/reliable-seller', [
    'as'   => 'forgetPassword_path',
    'uses' => 'PagesController@ReliableSeller'
]);
Route::get('/points-promotions', [
    'as'   => 'points_path',
    'uses' => 'PagesController@Points'
]);
Route::get('/purchasing', [
    'as'   => 'purchasing_path',
    'uses' => 'PagesController@Purchasing'
]);
Route::get('/faqs', [
    'as'   => 'faqs_path',
    'uses' => 'PagesController@Faqs'
]);
/**
 * User & Profile
 */
Route::resource('users', 'UsersController');

Route::resource('profile', 'ProfilesController', [
    'only' => ['show', 'edit', 'update']
]);
Route::post('profile/{user}/reviews',[
    'as' => 'profile_review',
    'uses' => 'UsersController@postReview'
]);
Route::get('profile/{user}/reviews',[
    'as' => 'profile_reviews',
    'uses' => 'UsersController@Reviews'
]);

Route::get('profile/{user}/favorites',[
    'as' => 'profile_favorites',
    'uses' => 'ProfilesController@Favorites'
]);



/**
 * products & categories
 */
Route::resource('products', 'ProductsController');

Route::get('search', [
    'as' => 'products_search',
    'uses' => 'ProductsController@search'
]);
Route::get('/products', [
    'as'   => 'products_path',
    'uses' => 'ProductsController@index'
]);
Route::get('/products/{product}/payment',[
    'as'   => 'product_payment',
    'uses' => 'ProductsController@payment'
]);
Route::post('/products/{product}/purchase',[
    'as'   => 'product_payment.purchase',
    'uses' => 'ProductsController@purchase'
]);

/*Route::get('/products/receipt',[
    'as'   => 'purchase.response',
    'uses' => 'ProductsController@purchaseResponse'
]);*/
Route::post('/products/receipt',[
    'as'   => 'purchase.response',
    'uses' => 'ProductsController@purchaseResponse'
]);
/*Route::post('/products/payment',[
    'as'   => 'product_payment.store',
    'uses' => 'ProductsController@postPayment'
]);*/
Route::get('/products/create',[
    'as'   => 'product_create',
    'uses' => 'ProductsController@create'
]);
Route::get('/products/{product}', [
    'as'   => 'product_path',
    'uses' => 'ProductsController@show'
]);
Route::get('categories/{category}/products', [
        'as'   => 'category_products_path',
        'uses' => 'ProductsController@search']
);

//save, load & delete favorites front
Route::post('/products/{product}/favorites', [
    'as'   => 'save_favorites',
    'uses' => 'ProductsController@saveFavorites'
]);

Route::post('/products/{product}/deletefavorites', [
    'as'   => 'delete_favorites',
    'uses' => 'ProductsController@deleteFavorites'
]);




/*
 * Photos Gallery
 */
#photos(Gallery)
Route::post('photos', [
    'as'   => 'save_photo',
    'uses' => 'PhotosController@store'
]);
Route::post('photos/{photo}', [
    'as'   => 'delete_photo',
    'uses' => 'PhotosController@destroy'
]);



/**
 * Administration
 */
Route::group(['prefix' => 'admin', 'middleware' => 'authByRole:administrator'], function ()
{

    # Dashboard
    Route::get('/', [
        'as'   => 'dashboard',
        'uses' => 'Admin\DashboardController@index'

    ]);

    # Users
    Route::resource('users', 'Admin\UsersController');

    Route::get('users', [
        'as'   => 'users',
        'uses' => 'Admin\UsersController@index'

    ]);

    Route::get('users/register', [
        'as'   => 'user_register',
        'uses' => 'Admin\UsersController@create'
    ]);

    Route::post('users/register', [
        'as'   => 'user_register.store',
        'uses' => 'Admin\UsersController@store'
    ]);
    foreach (['active', 'inactive'] as $key)
    {
        Route::post('users/{user}/' . $key, array(
            'as'   => 'users.' . $key,
            'uses' => 'Admin\UsersController@' . $key,
        ));
    }
    Route::get('users/list', [
        'as' => 'users_list',
        'uses' => 'Admin\UsersController@list_users'
    ]);


    # Products
    Route::resource('products', 'Admin\ProductsController');

    foreach (['pub', 'unpub', 'feat', 'unfeat'] as $key)
    {
        Route::post('products/{product}/' . $key, array(
            'as'   => 'products.' . $key,
            'uses' => 'Admin\ProductsController@' . $key,
        ));
    }

    Route::post('products/multiple', [
        'as'   => 'option_multiple',
        'uses' => 'Admin\ProductsController@option_multiple'
    ]);



    Route::get('products', [
        'as'   => 'products',
        'uses' => 'Admin\ProductsController@index'
    ]);


    #photos(Gallery)
    Route::post('photos', [
        'as'   => 'save_photo',
        'uses' => 'Admin\PhotosController@store'
    ]);
    Route::post('photos/{photo}', [
        'as'   => 'delete_photo',
        'uses' => 'Admin\PhotosController@destroy'
    ]);

    # categories
    Route::resource('categories', 'Admin\CategoriesController');

    foreach (['up', 'down', 'pub', 'unpub', 'feat', 'unfeat'] as $key)
    {
        Route::post('categories/{category}/' . $key, [
            'as'   => 'categories.' . $key,
            'uses' => 'Admin\CategoriesController@' . $key,
        ]);
    }
    Route::get('categories', [
        'as'   => 'categories',
        'uses' => 'Admin\CategoriesController@index'
    ]);

    # tags

    Route::resource('tags', 'Admin\TagsController');

    Route::get('tags', [
        'as'   => 'tags',
        'uses' => 'Admin\ProductsController@index'
    ]);

    # options
    Route::resource('options', 'Admin\OptionsController');

    Route::get('options', [
        'as'   => 'options',
        'uses' => 'Admin\OptionsController@index'
    ]);
    # payments
    Route::resource('payments', 'Admin\PaymentsController');

    Route::get('payments', [
        'as'   => 'payments',
        'uses' => 'Admin\PaymentsController@index'
    ]);
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
