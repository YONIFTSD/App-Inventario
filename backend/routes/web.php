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
    });


     //proveedor
     $router->group(['prefix' => 'providers'], function () use ($router) {
        $router->get('/list/{search}', 'ProviderController@ListAll');
        $router->post('/add', 'ProviderController@Store');
        $router->put('/edit', 'ProviderController@Update');
        $router->delete('/delete/{id_provider}', 'ProviderController@Delete');
        $router->get('/view/{id_provider}', 'ProviderController@View');
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


    //cuenta por cobrar
    $router->group(['prefix' => 'accounts-receivable'], function () use ($router) {
        $router->get('/list/{state}/{search}', 'AccountReceivableController@ListAll');
        $router->post('/add', 'AccountReceivableController@Store');
        $router->put('/edit', 'AccountReceivableController@Update');
        $router->delete('/delete/{id_account_receivable}', 'AccountReceivableController@Delete');
        $router->get('/view/{id_account_receivable}', 'AccountReceivableController@View');
    });


    //pagos a cuenta
    $router->group(['prefix' => 'accounts-receivable-payment'], function () use ($router) {
        $router->get('/list/{id_account_receivable}', 'AccountReceivablePaymentController@ListAll');
        $router->post('/add', 'AccountReceivablePaymentController@Store');
        $router->put('/edit', 'AccountReceivablePaymentController@Update');
        $router->delete('/delete/{id_account_receivable_payment}', 'AccountReceivablePaymentController@Delete');
        $router->get('/view/{id_account_receivable_payment}', 'AccountReceivablePaymentController@View');
    });

    //egresos diaria
    $router->group(['prefix' => 'accounts-receivable-expenses'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'AccountReceivableExpenseController@ListAll');
        $router->post('/add', 'AccountReceivableExpenseController@Store');
        $router->put('/edit', 'AccountReceivableExpenseController@Update');
        $router->delete('/delete/{id_expense}', 'AccountReceivableExpenseController@Delete');
        $router->get('/view/{id_expense}', 'AccountReceivableExpenseController@View');
    });


    //report
    $router->group(['prefix' => 'report'], function () use ($router) {
        $router->post('/utility-daily-settlement', 'ReportController@UtilityDailySettlement');
        $router->post('/utility-management', 'ReportController@UtilityManagement');
        $router->post('/utility-account-receivable', 'ReportController@UtilityAccountReceivable');
        $router->post('/utility', 'ReportController@Utility');

        $router->post('/month-utility-daily-settlement', 'ReportController@MonthUtilityDailySettlement');
        $router->post('/month-utility-management', 'ReportController@MonthUtilityManagement');
        $router->post('/month-utility-account-receivable', 'ReportController@MonthUtilityAccountReceivable');
        $router->post('/month-utility', 'ReportController@MonthUtility');
    });

});


$router->group(['prefix' => 'audit'], function () use ($router) {
    $router->post('/add', 'AuditController@Store');
});


$router->get('/excel-report-utility-daily-settlement/{from}/{to}/{coin}', 'ReportController@ExcelUtilityDailySettlement');
$router->get('/excel-report-utility-management/{from}/{to}/{coin}', 'ReportController@ExcelUtilityManagement');
$router->get('/excel-report-utility-account-receivable/{from}/{to}/{coin}', 'ReportController@ExcelUtilityAccountReceivable');
$router->get('/excel-report-utility/{from}/{to}/{coin}', 'ReportController@ExcelUtility');

$router->get('/excel-report-month-utility-daily-settlement/{month}', 'ReportController@ExcelMonthUtilityDailySettlement');
$router->get('/excel-report-month-utility-management/{month}', 'ReportController@ExcelMonthUtilityManagement');
$router->get('/excel-report-month-utility-account-receivable/{month}', 'ReportController@ExcelMonthUtilityAccountReceivable');
$router->get('/excel-report-month-utility/{month}', 'ReportController@ExcelMonthUtility');
