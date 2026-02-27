<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Users</h1>
    </div>

    <div class="p-4">
        <p>List of Users</p>
        
        <div class="row justify-center overflow-x-scroll mb-3">
            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Users</p>
                <p>{{$userCount}}</p>
            </div>
            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Verified Users</p>
                <p>{{ $userVerifiedCount }}</p>
            </div>
            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Unverified Users</p>
                <p>{{ $userUnverifiedCount }}</p>
            </div>
        </div>

        <div class="flex justify-between mb-3 items-cent">            
            <form method="GET" action="#" class="flex items-center w-full space-x-2">
                <div class="relative col-5">
                    <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="px-3 py-2.5 bg-white border-black border rounded-[5px] ps-9 text-heading text-sm focus:ring-brand focus:border-brand block w-full placeholder:text-body" placeholder="Search Username/Email name..." required />
                </div>
                <button type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2 focus:outline-none">
                    <div class="text-white bg-[#0084C0] px-3 h-full rounded-2 items-center justify-center flex">
                        Search
                    </div>
                </button>
            </form>
            <a href="/Dashboard/User/add" class="inline-flex items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2">
                <div class="text-white bg-[#5F9598] px-3 py-2.5 h-full rounded-2 ">
                    +Add User
                </div>
            </a>
        </div>


        <div class="w-full min-h-[70vh] bg-white p-0 rounded-[10px] drop-shadow overflow-clip">
            <div class="relative overflow-x-auto shadow-xs border border-default">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body text-center border-b border-default bg-stone-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Username
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                IsVerified
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)                            
                            <tr class="bg-neutral-primary border-b border-default text-center">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    {{ $user->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->role->role }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->email_verified_at? "Verified" : "No" }}
                                </td>
                                <td class="px-6 py-4 flex justify-evenly">
                                    <a href="/Dashboard/User/info/{{ $user->id }}" class="text-white bg-[#1D546D] py-2 px-4">Edit</a>
                                    
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
        </div>

        <div class="mt-10 flex justify-end">
            {{ $users->links() }}
        </div>
    </div>
</x-dashboardLayout>