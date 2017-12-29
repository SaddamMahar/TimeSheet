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
*/

Route::get('/', function () {
    Auth::logout();
    return view('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//    custom routes

Route::get('staffDetail/update/active/{active_id}','StaffDetailController@updateStaffDetailActive');


Route::middleware(['auth'])->group(function () {

    Route::post('report/index','ReportController@index');
    Route::get('report/index','ReportController@index');
    Route::get('report/pie','ReportController@pie');
    Route::post('report/pie','ReportController@pie');
    Route::get('report/clientreport','ReportController@clientreport');
    Route::post('report/clientreport','ReportController@clientreport');
    Route::get('report/monthlyChart','ReportController@monthlyChart');




    Route::resource('dailyInput','DailyInputController');
    Route::Post('dailyInput','DailyInputController@getData');
    Route::post('dailyInput_save','DailyInputController@storeRecord');
    Route::post('dailyInput/update/','DailyInputController@updateDailyInput');
    Route::get('dailyInput/delete/{id}/','DailyInputController@delete');

    Route::post('passwordReset','DailyInputController@resetPassword');


    Route::middleware(['admin'])->group(function () {

        // dataTables
        //Route::post('allclients', 'ClientController@allClients' )->name('allclients');
        Route::post('allposts', 'ClientController@allClients' )->name('allposts');
        Route::post('allstaff', 'StaffDetailController@allStaff' )->name('allstaff');


        // dataTables end


        Route::Post('admin','AdminController@getData');
        Route::get('admin','AdminController@getData');
//        Route::get('admin','AdminController@getData');

        Route::resource('staffDetail','StaffDetailController');
        Route::resource('client','ClientController');
        Route::resource('designation','DesignationController');
        Route::resource('charge','ChargeController');
        Route::resource('task','TaskController');

        Route::get('staffDetail/delete/{id}/','StaffDetailController@delete');
        Route::get('client/delete/{id}/','ClientController@delete');
        Route::get('designation/delete/{id}/','DesignationController@delete');
        Route::get('charge/delete/{id}/','ChargeController@delete');
        Route::get('task/delete/{id}/','TaskController@delete');

        Route::post('staffDetail/update/','StaffDetailController@updateStaffDetail');
        Route::post('client/update/','ClientController@updateClient');
        Route::post('charge/update/','ChargeController@updateCharge');
        Route::post('designation/update/','DesignationController@updateDesignation');
        Route::post('task/update/','TaskController@updateTask');


        Route::get('search','ClientController@search');


//Route::get('/admin/dropdown','AdminController@ajaxCall');
//Route::Post('/admin/allClients','AdminController@allClients');
//Route::Post('/admin/allStaff','AdminController@allStaff');
    });
});
