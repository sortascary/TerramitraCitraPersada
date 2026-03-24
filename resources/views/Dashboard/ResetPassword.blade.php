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
              Confirm new password
          </h1>
          <div class="w-full bg-white rounded-lg shadow border-5 md:mt-0 sm:max-w-md xl:p-0 bg-gray-800 border-[#1D546D]">
              <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                  <form id="form" class="space-y-4 md:space-y-6" action="{{ route('password.reset', $token) }}" method="POST">
                    @csrf
                      <div>
                          <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Password</label>
                          <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                      </div>
                      <div>
                          <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 ">Confirm Password</label>
                          <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
                      </div>
                      <div>
                          <input name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ request('email') }}" required="" hidden>
                          <input name="token" id="token" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ $token }}" required="" hidden>
                      </div>
                      <div>
                        <div class="bg-[#1D546D] hover:bg-[#184458] focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg">
                          <button id="submitBtn" type="submit" class="w-full text-white font-medium text-sm px-5 py-2.5 text-center">Reset Password</button>
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
              </div>
    </section>
  </body>
</html>
