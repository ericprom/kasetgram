<!DOCTYPE html>
<html  lang="{{ app()->getLocale() }}">
<head>
  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}"/>
</head>
<body>
<div id="app"></div>
@include('scripts')
</body>
</html>