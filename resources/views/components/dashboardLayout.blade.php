<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEW TerraMitra Citra Persada Dashboard</title>
    <link rel="icon" href="/Logo/tcp_logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css');
    @vite('resources/css/dashboard.css');
  </head>
  <body style="display: flex">
    <x-dashboardSidebar/>
    <div class="ml-60 w-full">
      {{ $slot }}
    </div>
  </body>
</html>
