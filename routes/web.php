<?php

use App\Jobs\ImportProductJob;
use Illuminate\Support\Facades\Route;

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
    ImportProductJob::dispatch();
    //return (new \App\Jobs\ImportProductJob())->handle();
    return view('welcome');
});
