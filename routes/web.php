<?php

use Illuminate\Support\Facades\Route;

Route::get('updater',[Updater::class,'view'])->name('updater');
Route::get('updater/start/{mode?}',[Updater::class,'start'])->name('updater.start');
