<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvokableController;

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


/************************************************/
/************** route prefixing   ***************/
/************************************************/

Route::prefix('route-prefix')->group(function () {
    Route::get('/first', function () {
        return "This is first route";
    });

    Route::get('/second', function () {
        return "This is second route";
    });
});


/************************************************/
/***named routes can be used in view file to generate link   ***************/
/************************************************/

Route::get('/named-route/{id?}', function ($id=null) {
    dump(route('named.route', ['id' => $id, 'name' => 'Binod Manandhar', 'age' => 30]));
    return $id;
})->name('named.route'); 

/************************************************/
/**************       Redirects   ***************/
/************************************************/

Route::get('redirect', function () {
    return redirect()->route('named.route', ['id' => 1]);
});

 Route::get('/user', [UserController::class, 'index']); // This line seems incorrect, as Route::resource expects a controller class, not a method. It should be Route::resource('photos', UserController::class); if you want to use the UserController for resource routes.

/************************************************/
/**************  Resource Controller   **********/
/************************************************/

// Route::resource('photos', PhotoController::class);
// Route::resource('photos', PhotoController::class)->only(['index', 'show']);
// Route::resource('photos', PhotoController::class)->except(['create', 'store', 'update', 'destroy']);
Route::apiResource('photos', PhotoController::class); // without create and edit routes


/************************************************/
/*********  Single action Controller   **********/
/************************************************/
// we don't need to specify the method name in the controller, it will automatically call the __invoke method of the controller
Route::get('/invokable-controller', [InvokableController::class]);