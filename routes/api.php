<?php

use Masoudi\Nova\Tool\Http\Controllers\SettingsToolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SettingsToolController::class, 'read']);
Route::post('/', [SettingsToolController::class, 'write']);
