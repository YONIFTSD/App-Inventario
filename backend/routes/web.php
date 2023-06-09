<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/login', 'AuthenticateController@Login');
$router->post('/logout', 'AuthenticateController@Logout');

//usuarios

$router->group(['middleware' => 'role'], function () use ($router) {

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/list/{search}', 'UserController@ListAll');
        $router->post('/add', 'UserController@Store');
        $router->put('/edit', 'UserController@Update');
        $router->delete('/delete/{id_user}', 'UserController@Delete');
        $router->get('/view/{id_user}', 'UserController@View');
    });


    //tipo de usuario
    $router->group(['prefix' => 'user-type'], function () use ($router) {
        $router->get('/list/{search}', 'UserTypeController@ListAll');
        $router->post('/add', 'UserTypeController@Store');
        $router->put('/edit', 'UserTypeController@Update');
        $router->delete('/delete/{id_user_type}', 'UserTypeController@Delete');
        $router->get('/view/{id_user_type}', 'UserTypeController@View');

        $router->get('/list-actives', 'UserTypeController@ListActives');
        $router->get('/get-zones-privileges', 'UserTypeController@GetZonePrivilege');
    });

    //cliente
    $router->group(['prefix' => 'clients'], function () use ($router) {
        $router->get('/list/{search}', 'ClientController@ListAll');
        $router->post('/add', 'ClientController@Store');
        $router->put('/edit', 'ClientController@Update');
        $router->delete('/delete/{id_client}', 'ClientController@Delete');
        $router->get('/view/{id_client}', 'ClientController@View');

        $router->post('/search-select', 'ClientController@SearchSelect');
        $router->get('/list-active', 'ClientController@ListActives');
    });


     //proveedor
     $router->group(['prefix' => 'providers'], function () use ($router) {
        $router->get('/list/{search}', 'ProviderController@ListAll');
        $router->post('/add', 'ProviderController@Store');
        $router->put('/edit', 'ProviderController@Update');
        $router->delete('/delete/{id_provider}', 'ProviderController@Delete');
        $router->get('/view/{id_provider}', 'ProviderController@View');

        $router->get('/list-active', 'ProviderController@ListActives');
    });

    //categorias
    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('/list/{search}', 'CategoryController@ListAll');
        $router->post('/add', 'CategoryController@Store');
        $router->put('/edit', 'CategoryController@Update');
        $router->delete('/delete/{id_category}', 'CategoryController@Delete');
        $router->get('/view/{id_category}', 'CategoryController@View');
        $router->get('/list-active', 'CategoryController@ListActives');
    });

    //productos
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('/list/{search}', 'ProductController@ListAll');
        $router->post('/add', 'ProductController@Store');
        $router->put('/edit', 'ProductController@Update');
        $router->delete('/delete/{id_product}', 'ProductController@Delete');
        $router->get('/view/{id_product}', 'ProductController@View');

        $router->post('/search', 'ProductController@Search');

        $router->get('/list-actives', 'ProductController@ListActives');
    });

     //compras
     $router->group(['prefix' => 'purchases'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'PurchaseController@ListAll');
        $router->post('/add', 'PurchaseController@Store');
        $router->put('/edit', 'PurchaseController@Update');
        $router->delete('/delete/{id_purchase}', 'PurchaseController@Delete');
        $router->get('/view/{id_purchase}', 'PurchaseController@View');

        $router->post('/search', 'PurchaseController@Search');
    });

      //compras
      $router->group(['prefix' => 'sales'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'SaleController@ListAll');
        $router->post('/add', 'SaleController@Store');
        $router->put('/edit', 'SaleController@Update');
        $router->delete('/delete/{id_sale}', 'SaleController@Delete');
        $router->get('/view/{id_sale}', 'SaleController@View');
    });

     //data
     $router->group(['prefix' => 'data'], function () use ($router) {
        $router->get('/get-series/{type_invoice}', 'DataManagerController@GetSeries');
        $router->get('/get-series-by-id/{id_serie}', 'DataManagerController@GetSeriesById');
    });

     //data
     $router->group(['prefix' => 'kardex'], function () use ($router) {
        $router->get('/get-movement-by-product/{id_product}/{to}', 'KardexController@GetMovementByProduct');
    });
});
