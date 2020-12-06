<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

// Unprotected routes
Route::middleware("cors")->group(function() {

    Route::get("/", function () {
        return "Welcome";
    });

    Route::options("{any?}", function () {
        return new Response();
    })->where("any", ".*");
    
    //Customer Programmes
    Route::get("programs", "ProgramsController@index")->name("programs_list");
    Route::get("programs/{program_id}", "ProgramsController@show")->name("program_details");
    Route::post("programs/", "ProgramsController@store")->name("create_program");
    
    //Customers
    Route::get("customers", "CustomersController@index")->name("customers_list");
    Route::get("customers/{customer_id}", "CustomersController@show")->name("customers_details");
    Route::post("customers/", "CustomersController@store")->name("create_customers");
    




});



