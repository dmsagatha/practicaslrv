<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ $title ?? 'Laravel 9 Mix With Tailwind CSS' }}</title>
    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @stack('styles')

    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  </head>
  <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 font-sans text-gray-900">
      <main>
        {{ $slot }}
      </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    @stack('scripts')
  </body>
</html>