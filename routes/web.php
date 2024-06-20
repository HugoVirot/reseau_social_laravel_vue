<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// // permet d'entrer des urls dans la barre d'adresse et d'y accéder
// // (impossible normalement avec vue-router)
// Route::any('/{any}', function() {
//     return view('welcome');
// })->where(['any' => '.*']);