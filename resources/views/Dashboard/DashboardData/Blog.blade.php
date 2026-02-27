<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Blog</h1>
    </div>

    <div class="p-4">
        <p>List of Blogs</p>
        
        <div class="flex overflow-x-scroll  mb-3 px-5">

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Blogs</p>
                <p>{{ $contentCount }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Views</p>
                <p>{{ $viewCount }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Views Today</p>
                <p>{{ $viewDayCount }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Views this Week</p>
                <p>{{ $viewWeekCount }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Views this Month</p>
                <p>{{ $viewMonthCount }}</p>
            </div>

        </div>

        <div class="flex justify-between mb-3 items-cent">            
            <form method="GET" action="#" class="flex items-center w-full space-x-2">
                <div class="relative col-5">
                    <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="px-3 py-2.5 bg-white border-black border rounded-[5px] ps-9 text-heading text-sm focus:ring-brand focus:border-brand block w-full placeholder:text-body" placeholder="Search Blog name..." />
                </div>
                <button type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2 focus:outline-none">
                    <div class="text-white bg-[#0084C0] px-3 h-full rounded-2 items-center justify-center flex">
                        Search
                    </div>
                </button>
            </form>
            <a href="/Dashboard/Blog/add" class="inline-flex items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2">
                <div class="text-white bg-[#5F9598] px-3 py-2.5 h-full rounded-2 ">
                    +Add Blog
                </div>
            </a>
        </div>

        <div class="row">
            @foreach ($contents as $content)                
                <div class="bg-white w-full p-3 flex justify-between rounded-[10px] drop-shadow my-3">
                    <div class="flex items-center">
                        <div class="bg-stone-200" style="width: 100px; height: 100px;">
                            @if ($content->contentattachments->first())
                                <img src="{{ asset($content->contentattachments->first()->file) }}" alt="User avatar" style="width: 100px; height: 100px; object-fit: cover;">  
                      
                            @endif
                        </div>

                        <div class="ml-3">
                            <h3 class="mb-0">{{ $content->title }}</h3>
                            <div class="flex gap-3">
                                @if ($content->user_id != null)                                        
                                    <div class="flex items-center justify-center">
                                        <div  class="flex items-center">
                                            <svg class="w-7 h-7 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <p class="mb-0">{{ $content->user->name }}</p>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center">
                                        <div  class="flex items-center">
                                            <svg class="w-7 h-7 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <p class="mb-0">Konten1</p>
                                    </div>
                                @endif
                                <div class="flex items-center justify-center">
                                    <div  class="flex items-center">
                                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                    </div>
                                    <p class="mb-0">{{ $content->contentviews->count() }}</p>
                                </div>
                                <div class="flex items-center justify-center">
                                    <div  class="flex items-center">
                                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="mb-0">{{ $content->contentattachments->count() }}</p>
                                </div>
                                <div class="flex items-center justify-center">
                                    <div  class="flex items-center">
                                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M3.559 4.544c.355-.35.834-.544 1.33-.544H19.11c.496 0 .975.194 1.33.544.356.35.559.829.559 1.331v9.25c0 .502-.203.981-.559 1.331-.355.35-.834.544-1.33.544H15.5l-2.7 3.6a1 1 0 0 1-1.6 0L8.5 17H4.889c-.496 0-.975-.194-1.33-.544A1.868 1.868 0 0 1 3 15.125v-9.25c0-.502.203-.981.559-1.331ZM7.556 7.5a1 1 0 1 0 0 2h8a1 1 0 0 0 0-2h-8Zm0 3.5a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2H7.556Z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <p class="mb-0">{{ $content->comments->count() }}</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="flex ">
                        <a href="/Blog/{{ $content->id }}">
                            <div>
                                <svg class="w-7 h-7 text-black mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </div>
                        </a>
                        <a href="/Dashboard/Blog/edit/{{ $content->id }}">
                            <div>
                                <svg class="w-7 h-7 text-gray-800 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                            </div>
                        </a>
                        <form action="{{ route('delete.Blog', $content->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit"
                                onclick="return confirm('Delete this Blog?')"
                            >
                                <svg class="w-7 h-7 text-gray-800 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            <div class="my-10 flex justify-end">
                {{ $contents->links() }}
            </div>
        </div>
    </div>
</x-dashboardLayout>