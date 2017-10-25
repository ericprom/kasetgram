<!DOCTYPE html>
<html  lang="{{ app()->getLocale() }}">
<head>
  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}"/>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini" style="background-color: #ecf0f5;">
	<div id="app"></div>
	@include('scripts')
</body>
</html>