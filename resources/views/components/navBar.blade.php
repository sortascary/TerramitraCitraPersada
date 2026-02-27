@vite(['resources/js/navbar.js'])
<nav class='flex flex-row justify-between items-center navbar px-3 py-0 drop-shadow'>
        <div>
            <img src="/Logo/tcp.png"  class="navLogo">
        </div>

        {{-- Mobile View --}}
        <ul class="px-0 py-0 m-0 flex flex-column items-center sidebar">
          <li class="pt-2 px-3  text-right closeNav">
            <svg class="w-6 h-6 text-gray-800 dark:text-black inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
            </svg>
          </li>
            <li class="py-4 px-3">
                <a href="/" >Home</a>
            </li>
            <li class="py-4 px-3">
                <a href="/AboutUs" >About Us</a>
            </li>
            <li class="py-4 px-3">
                <a href="/Services" >Services</a>
            </li>
            <li class="py-4 px-3">
                <a href="/Client" >Clients</a>
            </li>
            <li class="py-4 px-3">
                <a href="/Blog" >Blog</a>
            </li>
            <li class="py-4 px-3">
                <a href="/Contact" >Contact</a>
            </li>
            <li class="py-4 px-3">
                <a href="#" >Download</a>
            </li>
            @auth
                <li class="px-2">
                    <button id="dropdownNvbarButtonMobile" data-dropdown-toggle="dropdownNavbarMobile" class="flex items-center justify-between w-full px-3 py-2 text-white" style="background-color: #253900; border-radius: 10px" dropdownM>
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbarMobile" class="z-10 hidden w-full bg-white border border-default-medium rounded-base shadow-lg max-w-50 absolute right-0 mr-3" dropdown-items-mobile>
                        <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownNvbarButtonMobile">
                            @if (auth()->user()->role?->role != "User")
                                <li>
                                    <a href="/Dashboard" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                        <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                                        <span class="ms-3">Dashboard</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                                        <span class="flex-1 ms-3 whitespace-nowrap text-red-500">Sign Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth
            @guest                
                <li class="mx-3 my-2" style="background-color: #253900; border-radius: 10px">
                    <a href="/login" style="color: white">
                        <button class="px-3 py-2">
                            Login
                        </button>
                    </a>
                </li>
            @endguest
         </ul>

        {{-- Web View --}}
         <ul class="p-0 m-0 flex items-center ">
            <li class="py-4 navLink {{ request()->is('/') ? 'border-b-2' : '' }}">
                <a href="/" class="py-4 px-3">Home</a>
            </li>
            <li class="py-4 navLink {{ request()->is('AboutUs') ? 'border-b-2' : '' }}">
                <a href="/AboutUs" class="py-4 px-3">About Us</a>
            </li>
            <li class="py-4 navLink {{ request()->is('Services') ? 'border-b-2' : '' }}">
                <a href="/Services" class="py-4 px-3">Services</a>
            </li>
            <li class="py-4 navLink {{ request()->is('Client') ? 'border-b-2' : '' }}">
                <a href="/Client" class="py-4 px-3">Clients</a>
            </li>
            <li class="py-4 navLink {{ request()->is('Blog') ? 'border-b-2' : '' }}">
                <a href="/Blog" class="py-4 px-3">Blog</a>
            </li>
            <li class="py-4 navLink {{ request()->is('Contact') ? 'border-b-2' : '' }}">
                <a href="/Contact" class="py-4 px-3">Contact</a>
            </li>
            <li class="py-4 navLink">
                <a href="#" class="py-4 px-3">Download</a>
            </li>
            @auth
                <li>
                    <button id="dropdownNavbarButton" data-dropdown-toggle="dropdownNavbar" class="flex items-center justify-between w-full px-3 py-2 navLink text-white" style="background-color: #253900; border-radius: 10px" dropdown>
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/></svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar" class="z-10 hidden bg-white border border-default-medium rounded-base shadow-lg max-w-50 absolute right-0 mr-3" dropdown-items>
                        <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownNvbarButton">
                            @if (auth()->user()->role?->role != "User")
                                <li>
                                    <a href="/Dashboard" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                        <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/></svg>
                                        <span class="ms-3">Dashboard</span>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                        <svg class="shrink-0 w-5 h-5 transition duration-75 group-hover:text-fg-brand text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/></svg>
                                        <span class="flex-1 ms-3 whitespace-nowrap text-red-500">Sign Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth
            @guest                
                <li class="px-3 py-2 navLink" style="background-color: #253900; border-radius: 10px">
                    <a href="/login" style="color: white">
                        <button >
                            Login
                        </button>
                    </a>
                </li>
            @endguest
            <li  class="py-4 px-3 hamburger">
              <svg class="w-6 h-6 text-gray-800 dark:text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
              </svg>
            </li>
         </ul>
</nav>