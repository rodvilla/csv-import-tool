<?php

namespace App\Http\Controllers\API;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessFileRequest;
use App\Http\Requests\ProcessMappingsRequest;

class ImportCsvController extends Controller
{
    public function processFile(ProcessFileRequest $request)
    {
        $file = $request->validated()['file'];

        $contents = collect($this->readCsv($file));

        // Make sure the CSV file has at least one row besides the header
        if ($contents->count() < 2) {
            return $this->errorResponse('File is empty');
        }

        return response()->json([
            'valid'   => true,
            'headers' => $contents->first(),
            'count'   => $contents->count() - 1,
            'name'    => $file->getClientOriginalName(),
            'path'    => $file->store('csv'),
        ]);
    }

    public function processMappings(ProcessMappingsRequest $request)
    {
        $mappings = $request->validated()['mappings'];
        $filePath = $request->validated()['path'];

        // Read the file again
        $rows = $this->readCsv(storage_path('app/' . $filePath));

        // We continue to assume the headers are in the first row
        $headers = $rows[0];

        $rowsToInsert = [];
        // Iterate the CSV rows to map them
        foreach ($rows as $rowIndex => $row) {
            $properties = [];
            $customAttributes = [];

            // Skip the headers
            if ($rowIndex === 0) {
                continue;
            }

            // Iterate each row's columns
            foreach ($row as $columnIndex => $columnValue) {
                $fieldMap = $mappings[$columnIndex];
                if ($fieldMap !== "custom") {
                    // Map the column value with a database column
                    $properties[$fieldMap] = $columnValue;
                } else {
                    // Get the attribute key from the headers
                    $customAttributes[] = [
                        'key'   => $headers[$columnIndex],
                        'value' => $columnValue
                    ];
                }
            }

            $rowsToInsert[] = [
                'properties' => $properties,
                'customAttributes' => $customAttributes
            ];
        }

        // The rows to insert are now prepared, save everything
        foreach ($rowsToInsert as $row) {
            // Persist the contact
            $contact = Contact::create($row['properties']);
            // Persist the custom attributes
            $contact->customAttributes()->createMany($row['customAttributes']);
        }

        // Return a fresh result set from the database
        return response()->json([
            'contacts' => Contact::with('customAttributes')->get()
        ]);
    }

    /**
     * Return an error response for the processFile logic
     *
     * @param string $error
     * @return \Illuminate\Http\ResponseResponse
     */
    private function errorResponse($error)
    {
        return response()->json([
            'valid' => false,
            'error' => $error,
        ]);
    }

    /**
     * Read the provided CSV file with core PHP functions
     * and return the rows in form of an array
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    private function readCsv($file)
    {
        $handle = fopen($file, 'r');
        while (!feof($handle)) {
            $lines[] = fgetcsv($handle, 0, ',');
        }
        fclose($handle);
        return $lines;
    }
}
