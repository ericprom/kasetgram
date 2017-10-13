<!DOCTYPE html>
<html>
<head>
    <title>Smart Farmer Management System</title>
    <link rel="stylesheet" href="{{ asset(elixir('css/app.css')) }}"/>
</head>
<body>
  <div id="app">
    <div class="container">
      <h3> Smart Farmer </h3>
      <div class="row">
        <div class="col-md-4">
          <navbar></navbar>
        </div>
        <div class="col-md-8">
          <router-view class="view"></router-view>
        </div>
      </div>
      <footer align="center">
        <p>Created with love. All Rights Reserved</p>
      </footer>
    </div>
  </div>
  <script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
  </script>
  <script type="application/javascript" src="{{ asset(elixir('js/app.js')) }}"></script>
</body>
</html>