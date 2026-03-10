<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\Setting::get('site_name', 'Terramitra Citra Persada') }}</title>
    <link rel="icon" href="/Logo/tcp_logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @vite('resources/css/app.css')
  </head>
  <body class=" text-center flex flex-col justify-center items-center h-[100svh]">
    <h2>Link Sent!</h2>
    <section>
      <main class="text-center flex flex-col justify-center items-center border-[#1D546D] shadow border-5 p-5 rounded-lg">
        <svg class="w-20 h-20 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
          <path d="M2.038 5.61A2.01 2.01 0 0 0 2 6v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6c0-.12-.01-.238-.03-.352l-.866.65-7.89 6.032a2 2 0 0 1-2.429 0L2.884 6.288l-.846-.677Z"/>
          <path d="M20.677 4.117A1.996 1.996 0 0 0 20 4H4c-.225 0-.44.037-.642.105l.758.607L12 10.742 19.9 4.7l.777-.583Z"/>
        </svg>


              {{-- @if ($success)
                  <svg class="checkmark w-40 h-40 text-green-500" viewBox="-2 -2 57 57" fill="none" stroke="currentColor" stroke-width="5">
                      <circle cx="26" cy="26" r="25" fill="none" />
                      <path d="M14 27 L22 35 L38 17" fill="none" stroke-linecap="round" stroke-linejoin="round" class="check" />
                  </svg>
              @else
                  <svg class="w-40 h-40 text-red-500" viewBox="0 0 52 52" fill="none" stroke="currentColor" stroke-width="5">
                      <line x1="15" y1="15" x2="37" y2="37" class="x-line" stroke-linecap="round" />
                      <line x1="37" y1="15" x2="15" y2="37" class="x-line" stroke-linecap="round" />
                  </svg>
              @endif
          <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 ">
              <h1 class="sm:text-xl lg:text-3xl">{{$message}}</h1>
          </div> --}}

          

          <a href="/" class="text-gray-500">you may now close this window</a>
      </main>
    </section>
  </body>
</html>
