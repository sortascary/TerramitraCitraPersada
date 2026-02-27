@vite('resources/css/chat.css')
@vite(['resources/js/chat.js'])

<button class="fab">
    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M3.559 4.544c.355-.35.834-.544 1.33-.544H19.11c.496 0 .975.194 1.33.544.356.35.559.829.559 1.331v9.25c0 .502-.203.981-.559 1.331-.355.35-.834.544-1.33.544H15.5l-2.7 3.6a1 1 0 0 1-1.6 0L8.5 17H4.889c-.496 0-.975-.194-1.33-.544A1.868 1.868 0 0 1 3 15.125v-9.25c0-.502.203-.981.559-1.331ZM7.556 7.5a1 1 0 1 0 0 2h8a1 1 0 0 0 0-2h-8Zm0 3.5a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2H7.556Z" clip-rule="evenodd"/>
    </svg>
</button>


@auth
    <canvas id="cameraCanvas" class="hidden w-full h-auto"></canvas>
    <script>
        window.authUserId = {{ auth()->id() ?? 'null' }};
    </script>
    <div id="messageMenu" class="z-999 right-0 bottom-0 bg-white border border-default-medium rounded-base shadow-lg w-40 h-fit absolute hidden">
            <ul class="p-2 text-sm font-medium bg-white" aria-labelledby="dropdownMenuIconButton">
                <li>
                    <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Reply</a>
                </li>
                <li>
                    <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Delete</a>
                </li>
            </ul>
        </div>
    <div class="hidden chat bottom-0 right-0 md:bottom-[24px] md:right-[24px] overlay-forum rounded-lg overflow-hidden shadow-2xl bg-stone-200 h-[90vh] flex flex-col w-full justify-between " style="height: 90vh;">
        
        <div class="bg-black flex justify-between items-center p-2 w-full">
            <div class="flex items-center">
                <div class="px-2 hidden cursor-pointer" id="backChat">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                </div>
                <h3 id="forumHeader" class="mx-2">Chats</h3>
            </div>
            <div>
                <svg class="w-6 h-6 text-white closeChat" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
            </div>
        </div>
        <div id="forumList" class="hidden h-full w-full overflow-y-scroll">
            {{-- Chats go here --}}
        </div>

        

        <div id="chatList" class=" px-2 h-full w-full overflow-y-scroll flex flex-col hidden">
            {{-- Chats go here --}}
            <div class="bg-[#242424] my-2 rounded-tr-lg rounded-br-lg rounded-bl-lg rounded-tl-none w-fit max-w-[70%] flex flex-col p-2">
                   <div class="flex">${usernameHTML}</div>
                   <div class="m-0">${msg.message}</div>
                   <div>
                        <img src="/images/visi.jpg" alt="">
                   </div>
                   <div class="m-0 text-[#D3D3D3] self-end">${time}</div>
                </div>
                <div class="bg-[#474747] my-2 rounded-tr-none rounded-br-lg self-end rounded-bl-lg rounded-tl-lg w-fit max-w-[70%] flex flex-col p-2">
                    <div class="flex">${usernameHTML}</div>
                    <div class="m-0">${msg.message}</div>
                    <div class="m-0 text-[#D3D3D3] self-end">${time}</div>
                </div>
                
                <div class="flex items-start my-2 message relative">
                    <div class="flex flex-col w-full max-w-[320px] bg-[#242424]  leading-1.5 p-3 bg-neutral-secondary-soft rounded-tr-lg rounded-br-lg rounded-bl-lg rounded-tl-none">
                        <div class="flex items-center space-x-1.5 rtl:space-x-reverse">
                            <span class="text-sm font-semibold text-heading">Bonnie Green</span>
                        </div>
                        <p class="text-sm py-2.5">That's awesome. I think our users will really appreciate the improvements.</p>
                        <div class="group relative w-fit">
                            <div class="absolute inset-0 z-10 bg-gray-900/50 reveal transition-opacity duration-300 rounded-lg flex items-center justify-center">
                                <button data-tooltip-target="download-image" class="inline-flex items-center justify-center rounded-full h-10 w-10 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none focus:ring-white">
                                    <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                                </button>
                                <div id="download-image" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-dark rounded-lg shadow-xs opacity-0 tooltip">
                                    Download image
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                            <img src="/images/visi.jpg" class="rounded-lg block relative z-0" />
                        </div>
                        <span class="text-sm self-end">8:35</span>
                    </div>
                    <button class="MessageMenuIconButton text-body inline-flex self-center items-center hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary focus:ring-4 focus:ring-neutral-tertiary rounded-base p-1.5 focus:outline-none" type="button">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                    </button>
                   
                </div>

                
                <div class="flex items-start my-2">
                    <div class="flex flex-col gap-1">
                        <div class="flex flex-col w-full max-w-[326px] bg-[#242424] leading-1.5 p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg rounded-tl-none text-white">
                            <div class="flex items-center space-x-1.5 rtl:space-x-reverse mb-2">
                                <span class="text-sm font-semibold text-heading">Bonnie Green</span>
                                <span class="text-sm ">11:46</span>
                            </div>
                            <p class="text-sm ">This is the new office <3</p>
                            <div class="grid gap-4 grid-cols-2 my-2.5">
                                <div class="group relative">
                                    <div class="absolute w-full h-full bg-gray-900/50 reveal transition-opacity duration-300 rounded-base flex items-center justify-center">
                                        <button data-tooltip-target="download-image-1" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                                            <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                                        </button>
                                    <div id="download-image-1" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-dark rounded-base shadow-xs opacity-0 tooltip">
                                        Download image
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <img src="/images/visi.jpg" class="rounded-base" />
                            </div>
                            <div class="group relative">
                                <div class="absolute w-full h-full bg-gray-900/50 reveal transition-opacity duration-300 rounded-base flex items-center justify-center">
                                    <button data-tooltip-target="download-image-2" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                                    </button>
                                    <div id="download-image-2" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-dark rounded-base shadow-xs opacity-0 tooltip">
                                        Download image
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <img src="/images/visi.jpg" class="rounded-base" />
                            </div>
                            <div class="group relative">
                                <div class="absolute w-full h-full bg-gray-900/50 reveal transition-opacity duration-300 rounded-base flex items-center justify-center">
                                    <button data-tooltip-target="download-image-3" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                                        <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                                    </button>
                                    <div id="download-image-3" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-dark rounded-base shadow-xs opacity-0 tooltip">
                                        Download image
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <img src="/images/visi.jpg" class="rounded-base" />
                            </div>
                            <div class="group relative">
                                <button class="absolute w-full h-full bg-brand/90 hover:bg-brand/30 transition-all duration-300 rounded-base flex items-center justify-center">
                                    <span class="text-xl font-medium text-white">+7</span>
                                    <div id="download-image" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-dark rounded-base shadow-xs opacity-0 tooltip">
                                        Download image
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </button>
                                <img src="/images/visi.jpg" class="rounded-base" />
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm ">Delivered</span>
                            <button class="text-sm text-fg-brand font-medium inline-flex items-center hover:underline">
                            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                            Save all
                            </button>
                        </div>
                    </div>
                </div>
                <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center text-body hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary focus:ring-4 focus:ring-neutral-tertiary rounded-base p-1.5 focus:outline-none" type="button">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                </button>
                <div id="dropdownDots" class="z-10 right-0 bottom-3 bg-white border border-default-medium rounded-base shadow-lg w-40 absolute hidden">
                    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownMenuIconButton">
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Reply</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Forward</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Copy</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Report</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="flex items-start gap-2.5">
                <div class="flex flex-col w-full max-w-[320px] leading-1.5 bg-[#242424] p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg rounded-tl-none text-white">
                    <span class="text-sm font-semibold text-heading">Bonnie PDF</span>
                        <div class="flex items-start my-2.5 bg-neutral-tertiary rounded-base p-2">
                            <div class="me-1.5">
                                <span class="flex items-center gap-2 text-sm font-medium text-heading pb-2">
                                    <svg fill="none" aria-hidden="true" class="w-5 h-5 shrink-0" viewBox="0 0 20 21">
                                        <g clip-path="url(#clip0_3173_1381)">
                                            <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                            <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                            <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                            <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                            <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                            <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_3173_1381">
                                            <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    Flowbite Terms & Conditions
                                </span>
                                <span class="flex text-xs font-normal text-heading gap-2">
                                    12 Pages 
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="3" height="4" viewBox="0 0 3 4" fill="none">
                                        <circle cx="1.5" cy="2" r="1.5" fill="#6B7280"/>
                                    </svg>
                                    18 MB 
                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="3" height="4" viewBox="0 0 3 4" fill="none">
                                        <circle cx="1.5" cy="2" r="1.5" fill="#6B7280"/>
                                    </svg>
                                    PDF
                                </span>
                            </div>
                        <div class="inline-flex self-center items-center">
                        <button class="text-heading bg-neutral-tertiary box-border border border-transparent hover:bg-neutral-quaternary focus:ring-4 focus:ring-neutral-quaternary font-medium leading-5 rounded-base p-2 focus:outline-none" type="button">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/></svg>
                        </button>
                        </div>
                    </div>
                    <span class="text-sm">11:46</span>
                </div>
                <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" data-dropdown-placement="bottom-start" class="inline-flex self-center items-center text-body hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary focus:ring-4 focus:ring-neutral-tertiary rounded-base p-1.5 focus:outline-none" type="button">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                </button>
                <div id="dropdownDots" class="z-10 bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-40 block hidden">
                    <ul class="p-2 text-sm text-body font-medium" aria-labelledby="dropdownMenuIconButton">
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Reply</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Forward</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Copy</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Report</a>
                        </li>
                        <li>
                            <a href="#" class="block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
        
        <div id="messageInput" class=" bg-[#D9D9D9] px-3 py-4 flex flex-col items-center w-full gap-2">

            <div class="bg-[#F1ECEC] w-full text-stone-500 hidden">
                <div class="flex">${usernameHTML}</div>
                <div class="m-0">${msg.message}</div>
            </div>
            
            <div class="flex items-center">
                <svg class="w-5 h-5 text-black shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.99 9H15M8.99 9H9m12 3a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM7 13c0 1 .507 2.397 1.494 3.216a5.5 5.5 0 0 0 7.022 0C16.503 15.397 17 14 17 13c0 0-1.99 1-4.995 1S7 13 7 13Z"/>
                </svg>
    
                <svg class="w-5 h-5 text-black shrink-0 cursor-pointer" id="attachmentToggle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8"/>
                </svg>
    
                <div class="cursor-pointer hidden" id="backAttachment">
                    <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                    </svg>
                </div>
    
                <input type="file" id="fileInput"  accept="*"  class="hidden" />
                <input type="file" id="imageInput"  accept="image/*"  class="hidden" multiple/>
    
                <div id="CameraMenu" class="hidden w-full absolute bottom-20 left-0 bg-white shadow-lg rounded-lg p-3 flex flex-col justify-evenly gap-2 z-50">
                    <video id="video" class="object-fit"></video>
                    <div id="cameraButton" class="absolute bottom-5 left-[50%] cursor-pointer hover:text-white"  style="transform: translateX(-50%)">
                        <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M7.5 4.586A2 2 0 0 1 8.914 4h6.172a2 2 0 0 1 1.414.586L17.914 6H19a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1.086L7.5 4.586ZM10 12a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2-4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
    
    
                <div id="attachmentMenu" class="hidden w-full absolute bottom-20 left-0 bg-white shadow-lg rounded-lg p-3 flex justify-evenly gap-2 z-50">
    
                    <button type="button" class="attachmentOption text-black items-center flex flex-col" data-type="file">
                        <div>
                            <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span>
                            File
                        </span>
                    </button>
                    <button type="button" class="attachmentOption text-black items-center flex flex-col" data-type="image">
                        <div>
                            <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span>
                            Image
                        </span>
                    </button>
                    <button type="button" class="attachmentOption text-black items-center flex flex-col" data-type="camera">
                        <div>
                            <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M7.5 4.586A2 2 0 0 1 8.914 4h6.172a2 2 0 0 1 1.414.586L17.914 6H19a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1.086L7.5 4.586ZM10 12a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2-4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span>
                            Camera
                        </span>
                    </button>
                    <button type="button" class="attachmentOption text-black items-center flex flex-col" data-type="poll">
                        <div>
                            <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                            </svg>
                        </div>
                        <span>
                            Create Poll
                        </span>
                    </button>
    
                </div>
    
                <form id="chatForm" class="w-full flex gap-2 justify-between">
                    @csrf
                    <input type="hidden" name="forum_id" id="forum_id">
                    <input 
                        id="messageData"
                        name="message"
                        type="text" 
                        placeholder="Type a message..."
                        class="flex-1 rounded-[5px] p-2 outline-none bg-white text-black"
                    >
                    <button id="sendMessage" type="submit" class="bg-black text-white px-4 py-2 rounded-full">
                        Send
                    </button>
                </form>
            </div>

        </div>
    </div>
@endauth

@guest

    <div class="overlay-forum right-20 bottom-20 w-full h-fit space-y-4 max-w-xs p-3 text-body bg-gray-100 rounded-base shadow-xs border border-default">
        <div class="flex">
            <div class="inline-flex items-center justify-center shrink-0 w-9 h-9 text-fg-brand bg-neutral-primary-medium rounded">
                <svg class="w-5 h-5 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>

                <span class="sr-only">Refresh icon</span>
            </div>
            <div class="ms-3 text-sm font-normal text-body">
                <span class="mb-1 text-base font-medium text-heading">Login First!</span>
                <div class="mb-3">Please Log in to use this feature.</div> 
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" data-dismiss-target="#toast-interactive" class="closeChat w-full text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">Not now</button>
                    <button type="button" onclick="location.href = '/login'" class="w-full inline-flex items-center justify-center bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-xs px-3 py-1.5 focus:outline-none">
                        <svg class="w-3.5 h-3.5 me-1.5 -ms-0.5 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                        </svg>

                        Login
                    </button> 
                </div>    
            </div>
        </div>
    </div>

@endguest
