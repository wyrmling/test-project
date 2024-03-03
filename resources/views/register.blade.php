@extends('layout')

@section('content')
    <div class="bg-white w-1/4 p-8 rounded-lg shadow-lg">
        <div id="app">
            <register-form
                register-route="{{ route('register') }}"
                login-route="{{ route('login') }}"
            ></register-form>
        </div>
    </div>
@endsection

@section('js_footer')
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    @vite('resources/js/app.js')
@endsection
