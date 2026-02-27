<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Forum</h1>
    </div>

    <div class="p-4">
        <p>List of Forums</p>
        
        <div class="bg-white w-full mx-2 my-5 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
            <p>Total Forums</p>
            <p>{{ $forumCount }}</p>
        </div>

        <div class="flex justify-between mb-3 items-cent">            
            <form method="GET" action="#" class="flex items-center w-full space-x-2">
                <div class="relative col-5">
                    <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="px-3 py-2.5 bg-white border-black border rounded-[5px] ps-9 text-heading text-sm focus:ring-brand focus:border-brand block w-full placeholder:text-body" placeholder="Search Forum name..."  />
                </div>
                <button type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2 focus:outline-none">
                    <div class="text-white bg-[#0084C0] px-3 h-full rounded-2 items-center justify-center flex">
                        Search
                    </div>
                </button>
            </form>
            <a href="/Dashboard/Forum/add" class="inline-flex items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2">
                <div class="text-white bg-[#5F9598] px-3 py-2.5 h-full rounded-2 ">
                    +Add Forum
                </div>
            </a>
        </div>
        

        <div class="row">
            @foreach ($forums as $forum)
                
            <div class="bg-white w-full p-3 flex justify-between rounded-[10px] drop-shadow my-2">
                <div class="flex items-center">
                    <div class="bg-stone-200 rounded-circle items-center justify-center flex" style="width: 100px; height: 100px; object-fit: cover;">
                        @if ($forum->image)
                        <img src="{{ asset($forum->image) }}" alt="User avatar" class="bg-stone-200 rounded-circle " style="width: 100px; height: 100px; object-fit: cover;">
                            
                        @else
                        <h2 class="m-0">
                            {{ collect(explode(' ', $forum->name))
                            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                            ->join('') }}
                        </h2>                            
                        @endif
                    </div>
                    
                    <div class="ml-3">
                        <h3 class="mb-0">{{ $forum->name }}</h3>
                        <div class="flex gap-3">
                            <div class="flex items-center justify-center">
                                <div  class="flex items-center">
                                    <svg class="w-7 h-7 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="mb-0">{{ $forum->forumAccess->count() }}</p>
                            </div>
                            <div class="flex items-center justify-center">
                                <div  class="flex items-center">
                                    <svg class="w-7 h-7 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-6.616l-2.88 2.592C8.537 20.461 7 19.776 7 18.477V17H5a2 2 0 0 1-2-2V6Zm4 2a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2H7Zm8 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2Zm-8 3a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm5 0a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="mb-0">{{ $forum->messageforum->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-full flex flex-col justify-between">
                    <div class="flex ">
                        <a href="/Dashboard/Forum/info/{{ $forum->id }}">
                            <div>
                                <svg class="w-7 h-7 text-gray-800 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                            </div>
                        </a>
                        <form action="{{ route('delete.Forum', $forum->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                onclick="return confirm('Delete this user?')"
                            >
                                <svg class="w-7 h-7 text-gray-800 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <p>{{ $forum->created_at->format('d M Y') }}</p>

                </div>
            </div>
            @endforeach

            <div class="my-10 flex justify-end">
                {{ $forums->links() }}
            </div>
        </div>
    </div>
</x-dashboardLayout>