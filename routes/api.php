<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ImportCsvController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('process-file', [ImportCsvController::class, 'processFile'])
    ->name('api.process-file');
Route::post('process-mappings', [ImportCsvController::class, 'processMappings'])
    ->name('api.process-mappings');
