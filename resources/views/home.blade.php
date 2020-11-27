@extends('layouts.app')

@section('content')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight text-gray-900">Home</h1>
    </div>
</header>
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div id="app">
                <app
                :columns-map='@json($columnsMap)'
                :api-routes='@json($apiRoutes)'
                ></app>
            </div>
        </div>
    </div>
</main>
@endsection
