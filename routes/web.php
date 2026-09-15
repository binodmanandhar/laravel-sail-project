<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;


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
/************** Redirects   ***************/
/************************************************/

Route::redirect('/if-we-visit-this', '/welcome', 302);


/************************************************/
/****** Controller based routing   **************/
/************************************************/


Route::get('/controller-based-routing/{id}', [UserController::class, 'index']);

Route::get('/controller-implicit/{user:remember_token}', [UserController::class, 'show'])->name('user.show'); // http://localhost/controller-implicit/TyjtWYh74I



/************************************************/
/**************  Fallback Route   **************/
/************************************************/

Route::fallback(function () { // http://localhost/not-existing-url
    return "This is fallback route";
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
/************** Protecting Route   **************/
/************************************************/

Route::middleware('auth')->group(function () { // http://localhost/route-protected-by-middleware
    Route::get('/route-protected-by-middleware', [UserController::class, 'create']);
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
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
