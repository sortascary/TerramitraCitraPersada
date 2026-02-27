<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Forums</h1>
    </div>

    <div class="p-4">
        <p>Edit Forum</p>

        <div class="bg-white h-[80vh] p-5">
            <button onclick="history.back()" class="pb-4">
                <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
            </button>
            <form id="form" action="{{ route('edit.Forum', $forum->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex ">
                    <div class="w-full col-10 pr-20 mb-10">
                        <div >
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                            <input type="text" name="name" id="name" value="{{ $forum->name }}" class="bg-gray-50 border border-black text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Work forum..." >
                        </div>
                        <div class="border border-black border-primary-600 block w-full p-2.5 rounded-lg my-3">
                            <div >
                                <label for="userSearch" class="block mb-2 text-sm font-medium text-gray-900">Users</label>
                                <input type="text" id="userSearch"  class="bg-gray-50 border border-black text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Search for users/roles..." >
                            </div>
                            <div id="userList" class="h-[30vh] border border-black block w-full p-2.5 rounded-lg my-3 overflow-y-scroll flex flex-col">
                                @foreach ($users as $user)
                                    <div class="user-item flex items-center gap-3 my-2 bg-white p-2 justify-between rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <div class="h-16 w-16 flex flex-shrink-0 flex-col bg-stone-200 items-center justify-center rounded-circle overflow-clip">
                                                @if ($user->image)
                                                    <img src="{{ asset($user->image) }}" class="h-16 w-16" style="object-fit: cover">
                                                @else
                                                    <p class="m-0 text-center">no image</p>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="m-0">{{ $user->name }}</span>
                                                <p class="m-0">{{ $user->email }}</p>
                                            </div>
                                        </div>

                                        <label class="flex items-center gap-2 p-1 user-item">
                                            <input type="checkbox" 
                                                name="users[{{ $loop->index }}][user_id]" 
                                                value="{{ $user->id }}"
                                                class="user-checkbox"
                                                {{ $forum->users->contains($user->id) ? 'checked' : '' }}>
                                            <span class="user-name hidden">{{ $user->name }}</span>
                                            <span class="user-email hidden">{{ $user->email }}</span>
                                            <span class="user-role hidden">{{ $user->role->role }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="flex flex-col items-center ">
                        <label for="image" class="block mb-2 text-xl font-medium text-gray-900">Profile</label>
                        <label for="image" class="h-24 w-24 rounded-circle ">
                            <div id="empty" class="h-24 w-24 flex flex-col bg-stone-200 items-center justify-center rounded-circle pt-5 pb-6">
                                <div>
                                    <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M7.5 4.586A2 2 0 0 1 8.914 4h6.172a2 2 0 0 1 1.414.586L17.914 6H19a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h1.086L7.5 4.586ZM10 12a2 2 0 1 1 4 0 2 2 0 0 1-4 0Zm2-4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div id="filled" class="h-24 w-24 flex flex-col bg-stone-200 items-center justify-center rounded-circle overflow-clip hidden">
                                <div>
                                    <img id="preview" alt="" style="object-fit: cover">
                                </div>
                            </div>
                            <input type="file" name="image" id="image" class="hidden" value="{{ $forum->image }}" >
                        </label>
                    </div>
                </div>
                <div class="bg-[#1D546D] hover:bg-[#184458] focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg">
                    <button id="submitBtn" type="submit" class="w-full text-white font-medium text-sm px-5 py-2.5 text-center">Save</button>
                </div>
                @if ($errors->any())
                  <ul class="p-0">
                    @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                  </ul>
                @endif
            </form>
        </div>
    </div>
    @vite(['resources/js/forms.js'])
    @vite(['resources/js/DashForum.js'])
</x-dashboardLayout>