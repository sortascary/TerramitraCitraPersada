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
        window.authUserRole = @json(optional(auth()->user())->role?->role);
    </script>
    <div id="messageMenu" class="z-999 right-0 bottom-0 bg-white border border-default-medium rounded-base shadow-lg w-40 h-fit absolute hidden">
            <ul class="p-2 text-sm font-medium bg-white">
                <li>
                    <a class="reply-btn block w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded-md">Reply</a>
                </li>
                <li id="deleteOption" class="hidden">
                    <a class="delete-btn block w-full p-2 hover:bg-red-100 hover:text-red-600 rounded-md">Delete</a>
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
        </div>
        
        <div id="messageInput" class=" bg-[#D9D9D9] px-3 py-4 flex flex-col items-center w-full gap-2">

            <div id="pollModal" class="hidden absolute inset-0 bg-black/50 z-50 flex items-center justify-center">
                <div class="bg-white text-black rounded-lg p-4 w-full mx-4">
                    <h3 class="font-semibold text-lg mb-3">Create Poll</h3>

                    <input id="pollQuestion" type="text" placeholder="Ask a question..." class="w-full border rounded-lg p-2 mb-3 text-sm outline-none" />

                    <div id="pollOptions" class="flex flex-col gap-2 mb-3">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Option 1" class="poll-option-input flex-1 border rounded-lg p-2 text-sm outline-none" />
                        </div>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Option 2" class="poll-option-input flex-1 border rounded-lg p-2 text-sm outline-none" />
                        </div>
                    </div>

                    <button id="addPollOption" type="button" class="text-sm text-blue-500 hover:underline mb-3">+ Add option</button>

                    <div class="flex items-center gap-2 mb-4">
                        <input type="checkbox" id="pollAnonymous" class="rounded" />
                        <label for="pollAnonymous" class="text-sm">Anonymous voting</label>
                    </div>

                    <div class="flex gap-2 justify-end">
                        <button id="cancelPoll" type="button" class="px-4 py-2 text-sm rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                        <button id="submitPoll" type="button" class="px-4 py-2 text-sm rounded-lg bg-black text-white hover:bg-gray-800">Send Poll</button>
                    </div>
                </div>
            </div>

            <div id="replyPreview" class="px-2 flex justify-between bg-[#F1ECEC] w-full text-stone-500 hidden">
                <div>
                    <div class="flex">${usernameHTML}</div>
                    <div class="m-0">${msg.message}</div>
                </div>
                <button type="button" class="removeReply rounded-full w-6 h-6 text-xs flex self-start justify-center">&times;</button>
            </div>

            <div id="filePreview" class="hidden w-full bg-white rounded-lg p-2 flex flex-wrap gap-2 max-h-32 overflow-y-auto">
            </div>
            
            <div class="flex items-center">
    
                <svg class="w-6 h-6 text-black shrink-0 cursor-pointer mx-2" id="attachmentToggle" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8"/>
                </svg>
    
                <svg class="w-6 h-6 text-black cursor-pointer hidden mx-2" id="backAttachment" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
    
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
                        autocomplete="off"
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

    <div class="overlay-forum right-20 bottom-20 w-full h-fit space-y-4 max-w-xs p-3 text-body bg-gray-100 rounded-base shadow-xs border border-default hidden">
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
