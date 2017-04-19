<?php

use Relenta\Ply\Models\Factories\CourseFactory;

Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function () {
    //
    Route::resource('categories', 'Relenta\Ply\Http\Controllers\Categories');

    Route::resource('courses', 'Relenta\Ply\Http\Controllers\Courses');

    Route::resource('units', 'Relenta\Ply\Http\Controllers\Units');

    Route::resource('cards', 'Relenta\Ply\Http\Controllers\Cards');

    Route::resource('cardsides', 'Relenta\Ply\Http\Controllers\CardSides');

});

// Route::get('courses/create', function() {
//     $factory = new CourseFactory();
//     return $factory->create(11, 'New Course', dirname(__FIlE__) . '/tests/unit/models/factories/files/valid.zip');
// });
