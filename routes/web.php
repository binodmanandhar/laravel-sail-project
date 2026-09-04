<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/route-parameter/{name}/{id?}', function ($name, $id = null) {
    return "The name is: " . $name . " and the ID is: " . $id;
});

// order is important, not name
Route::get('/route-param/{name}/{id?}', function (string $name, int $id = null) {
    return "The name is: " . $name . " and the ID is: " . $id;
});

Route::get('/route/{a}/{b?}', function (Request $request, $a, $b = null) {
    return "$a and $b";
});

/************************************************/
/********  Pass parameter to view  **************/
/************************************************/
Route::view('/welcome', 'welcome', ['name' => 'Binod Manandhar']);


/************************************************/
/****** route parameter constraints  ************/
/************************************************/

// Route::get('/route-parameter-constraint/{name}/{id?}', function (string $name, int $id = null) {
//     return "The name is: " . $name . " and the ID is: " . $id;
// })->where(['name' => '[A-Za-z]+', 'id' => '[0-9]+']);

// added in app/ Providers/AppServiceProvider.php
Route::get('/route-parameter-constraint/{name}/{id?}', function ($name, $id) {
    return "The name is: " . $name . " and the ID is: " . $id;
});


/************************************************/
/************** Implict binding   ***************/
/************************************************/

Route::get('/implicit-binding/{user}', function (User $user) {
    return $user->email;
}); 