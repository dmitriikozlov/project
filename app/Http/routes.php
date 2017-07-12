<?php

Route::group(['middleware' => ['web']], function() {

    Route::group([
        'prefix'    => 'admin',
        'namespace' => 'Admin'
    ], function() {
        Route::pattern('id', '\d+');

        Route::get('admin/setting/{id?}', 'SettingController@show');
        Route::get('admin/setting/output/{id?}', 'SettingController@output');
        Route::post('admin/setting/input/{id?}', 'SettingController@input');
        Route::post('admin/setting/delete/{id}', 'SettingController@delete');

        Route::get('admin/setting/main-page', 'MainPageController@output');
        Route::post('admin/setting/main-page', 'MainPageController@input');
    });

    Route::post('new-category/products', 'Site\NewCategoryController@products');
    Route::get('catalog/{url}', 'Site\NewCategoryController@category');

    Route::get('admin/pizza/{pizza_id}/size', 'Admin\PizzaSizeController@index');
    Route::get('admin/pizza/{pizza_id}/size/create', 'Admin\PizzaSizeController@create');
    Route::post('admin/pizza/{pizza_id}/size/store', 'Admin\PizzaSizeController@store');
    Route::get('admin/pizza/{pizza_id}/size/edit/{size_id}', 'Admin\PizzaSizeController@edit');
    Route::post('admin/pizza/{pizza_id}/size/update/{size_id}', 'Admin\PizzaSizeController@update');
    Route::post('admin/pizza/{pizza_id}/size/destroy/{size_id}', 'Admin\PizzaSizeController@destroy');

    Route::get('admin/pizza/category/{id}/ingredient', 'Admin\PizzaIngredientController@index');
    Route::get('admin/pizza/category/{id}/ingredient/create', 'Admin\PizzaIngredientController@create');
    Route::post('admin/pizza/category/{id}/ingredient/store', 'Admin\PizzaIngredientController@store');
    Route::get('admin/pizza/category/{id}/ingredient/edit/{id2}', 'Admin\PizzaIngredientController@edit');
    Route::post('admin/pizza/category/{id}/ingredient/update/{id2}', 'Admin\PizzaIngredientController@update');
    Route::post('admin/pizza/category/{id}/ingredient/destroy/{id2}', 'Admin\PizzaIngredientController@destroy');

    Route::get('admin/pizza', 'Admin\PizzaController@show');
    Route::post('admin/pizza', 'Admin\PizzaController@save');

    Route::resource('admin/pizza/category', 'Admin\PizzaCategoryController', ['except' => ['show']]);

    Route::get('pizza', 'Site\PizzaController@index');

    Route::post('pizza/order', 'Site\PizzaController@order');

    Route::post('pizza/minus', 'Site\PizzaController@minus');
    Route::post('pizza/plus', 'Site\PizzaController@plus');

    Route::post('pizza/remove', 'Site\PizzaController@remove');

    Route::post('pizza/clear-session', 'Site\PizzaController@clearSession');

    Route::post('newsite/order', 'Site\NewSiteController@order');
    Route::post('newsite/plus', 'Site\NewSiteController@plus');
    Route::post('newsite/minus', 'Site\NewSiteController@minus');
    Route::post('newsite/remove', 'Site\NewSiteController@remove');

    Route::get("test/{value?}", [
        'as' => 'test', 
        'uses' => 'TestController@test',
    ]);
	
	Route::resource('admin/meta', 'Admin\MetaController', ['except' => ['show']]);
    
    Route::get('pay', [
        'as' => 'site.pay.get',
        'uses' => 'Site\PayController@payGet',
    ]);
    
    Route::post('pay', [
        'as' => 'site.pay.post',
        'uses' => 'Site\PayController@payPost'
    ]);
    
    /*
     * SearchController
     */

    Route::get('search', [
        'as' => 'site.search.index',
        'uses' => 'Site\SearchController@index',
    ]);

    Route::post('search', [
        'as' => 'site.search.index',
        'uses' => 'Site\SearchController@index',
    ]);

    Route::post('search/find', [
        'as' => 'site.search.find',
        'uses' => 'Site\SearchController@find',
    ]);

    /*
     * RecipeController
     *
    Route::get('/recipes/{page?}', [
        'as' => 'site.recipe.index',
        'uses' => 'Site\RecipeController@index',
    ]);

    Route::get('/recipe/{id?}', [
        'as' => 'site.recipe.show',
        'uses' => 'Site\RecipeController@show',
    ]);
    */

    /*
     * NavController
     */
/*
    Route::get('/recipes/', [
        'as' => 'site.recipes',
        'uses' => 'Site\NavController@recipes',
    ]);

    Route::get('/about-us/', [
        'as' => 'site.aboutus',
        'uses' => 'Site\NavController@aboutUs',
    ]);

    Route::get('/express/', [
        'as' => 'site.express',
        'uses' => 'Site\NavController@express',
    ]);

    Route::get('/promos/', [
        'as' => 'site.shares',
        'uses' => 'Site\NavController@shares',
    ]);

    Route::get('/contacts/', [
        'as' => 'site.contacts',
        'uses' => 'Site\NavController@contacts',
    ]);
*/
    /*
     * SiteController
     */
    
    Route::any('feedback', [
        'as' => 'site.feedback',
        'uses' => 'Site\SiteController@feedback',
    ]);
    
    Route::post('submit', [
        'as' => 'site.submit',
        'uses' => 'Site\SiteController@submit',
    ]);
    
    Route::get('service/else/{count?}', [
        'as' => 'site.else',
        'uses' => 'Site\SiteController@elseGet',
    ]);

    Route::get('basket/amount', [
        'as' => 'site.basket.amount',
        'uses' => 'Site\SiteController@basketAmount',
    ]);

    Route::get('site/products', [
        'as' => 'site.search.products',
        'uses' => 'Site\SiteController@products',
    ]);

    Route::get('/', [
        'as' => 'site.index',
        'uses' => 'Site\SiteController@index',
    ]);

    Route::get('/service/order/{id}', [
        'as' => 'site.service.order',
        'uses' => 'Site\SiteController@orderAjax',
    ]);

    Route::get('/basket/', [
        'as' => 'site.basket',
        'uses' => 'Site\SiteController@basket',
    ]);

    Route::get('/service/price/', [
        'as' => 'site.service.price',
        'uses' => 'Site\SiteController@priceAjax',
    ]);

    Route::get('/service/basketprice/', [
        'as' => 'site.service.basketprice',
        'uses' => 'Site\SiteController@basketpriceAjax',
    ]);

    Route::get('/service/basket/', [
        'as' => 'site.service.basket',
        'uses' => 'Site\SiteController@basketAjax',
    ]);

    Route::get('/service/basket/plus/{id}', [
        'as' => 'site.service.basket.plus',
        'uses' => 'Site\SiteController@basketPlusAjax',
    ]);

    Route::get('/service/basket/minus/{id}', [
        'as' => 'site.service.basket.minus',
        'uses' => 'Site\SiteController@basketMinusAjax',
    ]);

    Route::get('/service/basket/remove/{id}', [
        'as' => 'site.service.basket.remove',
        'uses' => 'Site\SiteController@basketRemoveAjax',
    ]);

    Route::get('/service/search/{text}', [
        'as' => 'site.service.search',
        'uses' => 'Site\SiteController@searchAjax',
    ]);

    Route::get('/service/category/', [
        'as' => 'site.service.category',
        'uses' => 'Site\SiteController@categoryAjax',
    ]);




    /*
     * Site: ProductController
     */
//    Route::get('/product/{id?}', [
//        'as' => 'site.product.index',
//        'uses' => 'Site\ProductController@index',
//    ]);

    Route::get('/products/random/', [
        'as' => 'site.product.random',
        'uses' => 'Site\ProductController@random'
    ]);

    /*
     * Site: CategoryController
     */
//    Route::get('/category/{url?}', [
//        'as' => 'site.category.index',
//        'uses' => 'Site\CategoryController@index',
//    ]);

    Route::post('/category/service/products/', [
        'as' => 'site.category.service.products',
        'uses' => 'Site\CategoryController@productsAjax',
    ]);

    /*
     * AdminController
     */

    Route::match(['get', 'post'], 'admin/register', [
        'as' => 'admin.register',
        'uses' => 'Admin\AdminController@register',
    ]);
    Route::match(['get', 'post'], 'admin/edit/{id}', [
        'as' => 'admin.edit',
        'uses' => 'Admin\AdminController@edit',
    ]);
    Route::post('admin/delete/{id}', [
        'as' => 'admin.delete',
        'uses' => 'Admin\AdminController@delete',
    ]);

    Route::get('/admin/', [
        'as' => 'admin.index',
        'uses' => 'Admin\AdminController@index',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'],'/admin/login/', [
        'as' => 'admin.login',
        'uses' => 'Admin\AdminController@login',
    ]);

    Route::get('/admin/logout/', [
        'as' => 'admin.logout',
        'uses' => 'Admin\AdminController@logout',
        'middleware' => 'admin',
    ]);


    /*
     * MarkController
     */

    Route::get('/admin/mark/', [
        'as' => 'admin.mark.index',
        'uses' => 'Admin\MarkController@index',
        'middleware' => 'admin',
    ]);

    Route::any('/admin/mark/create/', [
        'as' => 'admin.mark.create',
        'uses' => 'Admin\MarkController@create',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/mark/read/{id?}', [
        'as' => 'admin.mark.read',
        'uses' => 'Admin\MarkController@read',
        'middleware' => 'admin',
    ]);

    Route::any('/admin/mark/update/{id?}', [
        'as' => 'admin.mark.update',
        'uses' => 'Admin\MarkController@update',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/mark/delete/{id?}', [
        'as' => 'admin.mark.delete',
        'uses' => 'Admin\MarkController@delete',
        'middleware' => 'admin',
    ]);

    /*
     * IngredientController
     */

    Route::get('/admin/ingredient/', [
        'as' => 'admin.ingredient.index',
        'uses' => 'Admin\IngredientController@index',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/ingredient/create/', [
        'as' => 'admin.ingredient.create',
        'uses' => 'Admin\IngredientController@create',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/ingredient/read/{id}', [
        'as' => 'admin.ingredient.read',
        'uses' => 'Admin\IngredientController@read',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/ingredient/update/{id?}', [
        'as' => 'admin.ingredient.update',
        'uses' => 'Admin\IngredientController@update',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/ingredient/delete/{id}', [
        'as' => 'admin.ingredient.delete',
        'uses' => 'Admin\IngredientController@delete',
        'middleware' => 'admin',
    ]);

    /*
     * SizeController
     */

    Route::get('/admin/size/', [
        'as' => 'admin.size.index',
        'uses' => 'Admin\SizeController@index',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/size/create/', [
        'as' => 'admin.size.create',
        'uses' => 'Admin\sizeController@create',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/size/read/{id}', [
        'as' => 'admin.size.read',
        'uses' => 'Admin\SizeController@read',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/size/update/{id?}', [
        'as' => 'admin.size.update',
        'uses' => 'Admin\SizeController@update',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/size/delete/{id}', [
        'as' => 'admin.size.delete',
        'uses' => 'Admin\SizeController@delete',
        'middleware' => 'admin',
    ]);

    /*
     * ProductController
     */
	 
	Route::get('admin/product/create/product', [
		'as' => 'admin.product.create.product',
		'uses' => 'Admin\ProductController@productAjax',
	]);

    Route::get('/admin/product/', [
        'as' => 'admin.product.index',
        'uses' => 'Admin\ProductController@index',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/product/create/', [
        'as' => 'admin.product.create',
        'uses' => 'Admin\ProductController@create',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/product/create/size/', [
        'as' => 'admin.product.create.size',
        'uses' => 'Admin\ProductController@sizeajax',
    ]);

    Route::get('/admin/product/create/ingredient/', [
        'as' => 'admin.product.create.ingredient',
        'uses' => 'Admin\ProductController@ingredientajax',
    ]);

    Route::get('/admin/product/read/{id}', [
        'as' => 'admin.product.read',
        'uses' => 'Admin\ProductController@read',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/product/update/{id?}', [
        'as' => 'admin.product.update',
        'uses' => 'Admin\ProductController@update',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/product/delete/{id}', [
        'as' => 'admin.product.delete',
        'uses' => 'Admin\ProductController@delete',
        'middleware' => 'admin',
    ]);

    /*
     * CategoryController
     */

    Route::get('/admin/category/', [
        'as' => 'admin.category.index',
        'uses' => 'Admin\CategoryController@index',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/category/create/', [
        'as' => 'admin.category.create',
        'uses' => 'Admin\CategoryController@create',
        'middleware' => 'admin',
    ]);

    Route::get('admin/category/create/product', [
        'as' => 'admin.category.create.product',
        'uses' => 'Admin\CategoryController@productAjax',
    ]);

    Route::get('/admin/category/read/{id}', [
        'as' => 'admin.category.read',
        'uses' => 'Admin\CategoryController@read',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/category/update/{id?}', [
        'as' => 'admin.category.update',
        'uses' => 'Admin\CategoryController@update',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/category/delete/{id}', [
        'as' => 'admin.category.delete',
        'uses' => 'Admin\CategoryController@delete',
        'middleware' => 'admin',
    ]);

    /*
     * BasketController
     */

    Route::get('/admin/basket/', [
        'as' => 'admin.basket.index',
        'uses' => 'Admin\BasketController@index',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/basket/create/', [
        'as' => 'admin.basket.create',
        'uses' => 'Admin\BasketController@create',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/basket/create/product/', [
        'as' => 'admin.basket.create.product',
        'uses' => 'Admin\BasketController@productAjax',
    ]);

    Route::get('/admin/basket/read/{id}', [
        'as' => 'admin.basket.read',
        'uses' => 'Admin\BasketController@read',
        'middleware' => 'admin',
    ]);

    Route::match(['get', 'post'], '/admin/basket/update/{id?}', [
        'as' => 'admin.basket.update',
        'uses' => 'Admin\BasketController@update',
        'middleware' => 'admin',
    ]);

    Route::get('/admin/basket/delete/{id}', [
        'as' => 'admin.basket.delete',
        'uses' => 'Admin\BasketController@delete',
        'middleware' => 'admin',
    ]);

    Route::get('admin/settings/show', 'Admin\SettingsController@show');
    Route::put('admin/settings/show', 'Admin\SettingsController@updateAjax');
    Route::resource('admin/settings', 'Admin\SettingsController',[ 'except' => ['show'] ]);
    
    // Admin\PageController
    Route::resource('admin/page', 'Admin\PageController');


    Route::get('catalog','Site\PageController@catalogRoot');
    Route::get('catalog/{catAlias}/{prodAlias?}','Site\PageController@catalogRouter');

    Route::get('{url}', [
        'as' => 'page',
        'uses' => 'Site\PageController@index',
    ]);
});