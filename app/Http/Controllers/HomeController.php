<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Serve the home view with the data required from the backend
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('home', [
            'apiRoutes' => [
                'processFile' => route('api.process-file'),
                'processMappings' => route('api.process-mappings')
            ],
            'columnsMap' => Contact::$columnsMap,
        ]);
    }
}
