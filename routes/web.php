<?php

use App\Http\Controllers\ImportCsvController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home', [
        'apiRoutes' => [
            'processFile' => route('api.process-file'),
            'processMappings' => route('api.process-mappings')
        ],
        'columnsMap' => Contact::$columnsMap,
    ]);
});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {
    Route::post('process-file', [ImportCsvController::class, 'processFile'])->name('api.process-file');
    Route::post('process-mappings', [ImportCsvController::class, 'processMappings'])->name('api.process-mappings');
});
