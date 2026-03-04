<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEW TerraMitra Citra Persada</title>
    <link rel="icon" href="Logo/tcp_logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @vite('resources/css/app.css')
    @vite(['resources/js/forms.js'])
  </head>
  <body>
    <section>
      <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl py-10">
              Welcome back!
          </h1>
          <div class="w-full bg-white rounded-lg shadow border-5 md:mt-0 sm:max-w-md xl:p-0 bg-gray-800 border-[#1D546D]">
              <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <button onclick="location.href = '/'" class="pb-4">
                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                </button>
                  <form id="form" class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                      <div>
                          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                          <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">
                      </div>
                      <div>
                          <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                          <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                      </div>
                      <div class="flex items-center justify-between">
                          <div class="flex items-start">
                              <div class="flex items-center h-5">
                                <input id="remember" name="remember" type="checkbox"  value="1" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 ">
                              </div>
                              <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500">Remember me</label>
                              </div>
                          </div>
                          <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                      </div>
                      <div>
                        <label for="verify" class="block mb-2 text-sm font-medium text-gray-900">Verification</label>
                        <div for="verify" class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                      </div>
                      <div>
                        <div class="bg-[#1D546D] hover:bg-[#184458] focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg">
                          <button id="submitBtn" type="submit" class="w-full text-white font-medium text-sm px-5 py-2.5 text-center">Sign in</button>
                        </div>
                        @if ($errors->any())
                          <ul class="p-0">
                            @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                            @endforeach
                          </ul>
                        @endif
                      </div>
                    </form>
                  </div>
                </div>
                  <p class="text-sm font-light text-gray-500 ">
                      Don’t have an account yet? <a href="/register" class="font-medium text-blue-600 hover:underline ">Sign up</a>
                  </p>
              </div>
    </section>
  </body>
</html>
