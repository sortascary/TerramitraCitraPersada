<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Settings</h1>
    </div>

    <div class="p-4">

        <div class="bg-white h-[80vh] p-5 flex flex-col justify-between mb-4">
            <div>
                <button onclick="history.back()" class="pb-4">
                    <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                </button>
                <div class="flex">
                    <div id="filled" class="h-24 w-24 flex flex-col flex-shrink-0 bg-stone-200 items-center justify-center rounded-circle overflow-clip">
                        <div>
                            @if (Auth::user()->image)
                                <img src="{{ asset(Auth::user()->image) }}" id="preview" alt="" class="h-24 w-24" style="object-fit: cover">
                            @else
                            <p class="m-0">No image</p>
                                
                            @endif
                        </div>
                    </div>
    
                    <table class="w-full text-sm-right text-body">
                        <tbody>
                            <tr class="bg-neutral-primary border-b border-default">
                                <th scope="row" class="px-6 py-4">
                                    <p class="font-normal text-body">Username</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ Auth::user()->name }}</p>
                                </th>
                                <td class="px-6 py-4">
                                    <p>Email</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ Auth::user()->email }}</p>
                                    
                                </td>
                                <td class="px-6 py-4 ">
                                    <p>Role</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ Auth::user()->role->role }}</p>
                                    
                                </td>
                            </tr>
                            <tr class="bg-neutral-primary border-b border-default">
                                <th class="px-6 py-4 ">
                                    <p class="font-normal text-body">Created at</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ Auth::user()->created_at }}</p>
                                </th>
                                <td class="px-6 py-4">
                                    <p>is Verified</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ Auth::user()->email_verified_at? "Verified" : "No" }}</p>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-end w-full gap-3">
                <a href="/Dashboard/Settings/{{ Auth::user()->id }}" class="text-white bg-[#1D546D] py-2 px-4">Edit</a>
                                    
                <form action="{{ route('delete.User', Auth::user()->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit"
                        onclick="return confirm('Delete this user?')"
                        class="text-white bg-red-500 py-2 px-4"
                    >
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if (Auth::user()->role->role == 'Admin')
            <div class="bg-white h-[40vh] p-5">
                <h2>Website Settings</h2>
                @if(session('success'))
                    <p class="text-green-500 text-sm">{{ session('success') }}</p>
                @endif
                <div class=" flex flex-col justify-center h-full">
                    <form action="{{ route('edit.settings') }}" method="POST" class="flex-col flex">
                        @csrf
                        <div class="mb-5">
                            <label for="site_name" class="block mb-2 text-sm font-medium text-gray-900">Website Name</label>
                            <input type="text" value="{{ \App\Models\Setting::get('site_name', 'Terramitra Citra Persada') }}" name="site_name" id="site_name" class="bg-gray-50 border border-black text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Terramitra Citra Persada" required="">
                        </div>
                        <button type="submit" class="text-white bg-[#1D546D] py-2 px-4 rounded-lg self-end" >Save</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

</x-dashboardLayout>