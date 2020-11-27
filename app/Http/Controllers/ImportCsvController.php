<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportCsvController extends Controller
{
    public function processFile(Request $request)
    {
        $file = $request->file('file');
        // Validate file is CSV
        $validMimeTypes = ['text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel'];
        if (! in_array($file->getMimeType(), $validMimeTypes)) {
            return response()->json([
                'valid' => false,
                'error' => 'Invalid MIME type',
            ]);
        }

        // Validate file is not empty
        $file = $file->store('csv');

        return response()->json([
            'valid' => true,
            'file' => $file
        ]);
    }

    public function processMappings()
    {
        
    }
}
