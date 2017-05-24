<?php

use Relenta\Ply\Classes\Factories\CourseFactory;


Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () {

    Route::post('flash', 'Relenta\Ply\Http\Controllers\FlashCards@repeat');
    
    Route::get('learn', 'Relenta\Ply\Http\Controllers\Learn@index');
    //
    Route::resource('categories', 'Relenta\Ply\Http\Controllers\Categories');

    Route::resource('courses', 'Relenta\Ply\Http\Controllers\Courses');

    Route::resource('units', 'Relenta\Ply\Http\Controllers\Units');

    Route::resource('cards', 'Relenta\Ply\Http\Controllers\Cards');

    Route::resource('cardsides', 'Relenta\Ply\Http\Controllers\CardSides');

});


