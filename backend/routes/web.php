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

/**
 * Author: Yonathan William Mamani Calisaya
 * Fecha: 13-07-2022
 */
$router->post('/login', 'AuthenticateController@Login');

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


    //data manager
    $router->group(['prefix' => 'data-manager'], function () use ($router) {
        $router->get('/type-expenses', 'DataManagerController@ListTypeExpenses');
        $router->get('/list-business', 'DataManagerController@ListBusiness');
        $router->get('/get-correlative-by-module/{module}', 'DataManagerController@GetCorrelativeByModule');
        $router->get('/get-exchange-rate/{date}', 'DataManagerController@GetExchangeRate');
    });

    //tipo de gasto
    $router->group(['prefix' => 'type-expense'], function () use ($router) {
        $router->get('/list/{search}', 'TypeExpenseController@ListAll');
        $router->post('/add', 'TypeExpenseController@Store');
        $router->put('/edit', 'TypeExpenseController@Update');
        $router->delete('/delete/{id_type_expense}', 'TypeExpenseController@Delete');
        $router->get('/view/{id_type_expense}', 'TypeExpenseController@View');
    });


    //tipo de ingreso
    $router->group(['prefix' => 'type-income'], function () use ($router) {
        $router->get('/list/{search}', 'TypeIncomeController@ListAll');
        $router->post('/add', 'TypeIncomeController@Store');
        $router->put('/edit', 'TypeIncomeController@Update');
        $router->delete('/delete/{id_type_income}', 'TypeIncomeController@Delete');
        $router->get('/view/{id_type_income}', 'TypeIncomeController@View');

        $router->get('/list-active', 'TypeIncomeController@ListActive');
    });

    //egresos
    $router->group(['prefix' => 'expenses'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'ExpenseController@ListAll');
        $router->post('/add', 'ExpenseController@Store');
        $router->put('/edit', 'ExpenseController@Update');
        $router->delete('/delete/{id_expense}', 'ExpenseController@Delete');
        $router->get('/view/{id_expense}', 'ExpenseController@View');
    });

    //ingresos
    $router->group(['prefix' => 'incomes'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'IncomeController@ListAll');
        $router->post('/add', 'IncomeController@Store');
        $router->put('/edit', 'IncomeController@Update');
        $router->delete('/delete/{id_income}', 'IncomeController@Delete');
        $router->get('/view/{id_income}', 'IncomeController@View');

        $router->post('/get-income-business', 'IncomeController@GetIncomeBusiness');
    });


    //egresos diaria
    $router->group(['prefix' => 'daily-settlement-expenses'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'DailySettlementExpenseController@ListAll');
        $router->post('/add', 'DailySettlementExpenseController@Store');
        $router->put('/edit', 'DailySettlementExpenseController@Update');
        $router->delete('/delete/{id_expense}', 'DailySettlementExpenseController@Delete');
        $router->get('/view/{id_expense}', 'DailySettlementExpenseController@View');
    });

    //ingresos diarios
    $router->group(['prefix' => 'daily-settlement-incomes'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'DailySettlementIncomeController@ListAll');
        $router->post('/add', 'DailySettlementIncomeController@Store');
        $router->put('/edit', 'DailySettlementIncomeController@Update');
        $router->delete('/delete/{id_income}', 'DailySettlementIncomeController@Delete');
        $router->get('/view/{id_income}', 'DailySettlementIncomeController@View');

        $router->post('/get-income-business', 'DailySettlementIncomeController@GetIncomeBusiness');
    });





    //utilitdades
    $router->group(['prefix' => 'utilities'], function () use ($router) {
        $router->get('/list/{search}', 'UtilityController@ListAll');
        $router->post('/add', 'UtilityController@Store');
        $router->put('/edit', 'UtilityController@Update');
        $router->delete('/delete/{id_utility}', 'UtilityController@Delete');
        $router->get('/view/{id_utility}', 'UtilityController@View');

        $router->post('/get-utilities', 'UtilityController@GetUtility');
    });


    //egreso gerencial
    $router->group(['prefix' => 'management-expenses'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'ManagementExpenseController@ListAll');
        $router->post('/add', 'ManagementExpenseController@Store');
        $router->put('/edit', 'ManagementExpenseController@Update');
        $router->delete('/delete/{id_expense}', 'ManagementExpenseController@Delete');
        $router->get('/view/{id_expense}', 'ManagementExpenseController@View');
    });

    //ingreso gerencial
    $router->group(['prefix' => 'management-incomes'], function () use ($router) {
        $router->get('/list/{from}/{to}/{search}', 'ManagementIncomeController@ListAll');
        $router->post('/add', 'ManagementIncomeController@Store');
        $router->put('/edit', 'ManagementIncomeController@Update');
        $router->delete('/delete/{id_income}', 'ManagementIncomeController@Delete');
        $router->get('/view/{id_income}', 'ManagementIncomeController@View');

        $router->post('/get-balance-by-month', 'ManagementIncomeController@GetBalanceByMonth');
        
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
