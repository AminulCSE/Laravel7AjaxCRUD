<?php
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/students', 'StudentController@index');
Route::post('/add-student', 'StudentController@addStudent');
Route::get('/students/{id}', 'StudentController@getStudentById');
Route::put('/student', 'StudentController@updateStudent');
Route::delete('/students/{id}', 'StudentController@deleteStudent');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
