<!DOCTYPE html>
<html  lang="{{ app()->getLocale() }}">
<head>
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}"/>
    @php
    $config = [
        'appName' => config('app.name'),
        'locale' => $locale = app()->getLocale(),
        'translations' => json_decode(file_get_contents(resource_path("lang/{$locale}.json")), true),
    ];
    @endphp
    <script>window.config = {!! json_encode($config); !!};</script>
</head>
<body>
  <div id="app"></div>
  <script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
  </script>
  <script type="application/javascript" src="{{ asset(elixir('js/app.js')) }}"></script>
</body>
</html>