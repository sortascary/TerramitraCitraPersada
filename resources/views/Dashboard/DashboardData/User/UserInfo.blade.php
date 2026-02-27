<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Clients</h1>
    </div>

    <div class="p-4">

        <div class="bg-white h-[80vh] p-5 flex flex-col justify-between">
            <div>
                <button onclick="history.back()" class="pb-4">
                    <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                </button>
                <div class="flex">
                    <div id="filled" class="h-24 w-24 flex flex-col flex-shrink-0 bg-stone-200 items-center justify-center rounded-circle overflow-clip">
                        <div>
                            @if ($user->image)
                            <img src="{{ asset($user->image) }}" id="preview" alt="" class="h-24 w-24" style="object-fit: cover">
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
                                    <p class="font-medium text-heading whitespace-nowrap">{{ $user->name }}</p>
                                </th>
                                <td class="px-6 py-4">
                                    <p>Email</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ $user->email }}</p>
                                    
                                </td>
                                <td class="px-6 py-4 ">
                                    <p>Role</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ $user->role->role }}</p>
                                    
                                </td>
                            </tr>
                            <tr class="bg-neutral-primary border-b border-default">
                                <th class="px-6 py-4 ">
                                    <p class="font-normal text-body">Created at</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ $user->created_at }}</p>
                                </th>
                                <td class="px-6 py-4">
                                    <p>is Verified</p>
                                    <p class="font-medium text-heading whitespace-nowrap">{{ $user->email_verified_at? "Verified" : "No" }}</p>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-end w-full gap-3">
                <a href="/Dashboard/User/edit/{{ $user->id }}" class="text-white bg-blue-500 py-2 px-4">Edit</a>
                                    
                <form action="{{ route('delete.User', $user->id) }}" method="POST" class="inline">
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
    </div>
</x-dashboardLayout>