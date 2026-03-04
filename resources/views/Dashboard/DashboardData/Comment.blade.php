<x-dashboardLayout>
    <script>
        window.chartLabels = @json($commentData->pluck('date'));
        window.chartValues = @json($commentData->pluck('total'));
        window.chartLabelName = 'Comments';
    </script>
    @vite(['resources/js/chart.js'])

    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Comment</h1>
    </div>

    <div class="p-4">
        <p>List of Comment</p>
        
        <div class="row justify-center overflow-x-scroll mx-2 my-5">
            <div class="bg-white col-5 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Comments</p>
                <p>{{$commentCount}}</p>
            </div>
            <div class="bg-white col-5 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Comments Today</p>
                <p>{{ $commentTodayCount }}</p>
            </div>
        </div>

        <div class="flex mb-3">            
            <form method="GET" action="#" class="flex items-center w-full space-x-2">
                <div class="relative col-10">
                    <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="px-3 py-2.5 bg-white border-black border rounded-[5px] ps-9 text-heading text-sm focus:ring-brand focus:border-brand block w-full placeholder:text-body" placeholder="Search Comment/Username/Blog name..." />
                </div>
                <button type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs  focus:outline-none">
                    <div class="text-white bg-[#0084C0] px-3 h-full rounded-[10px] items-center justify-center flex">
                        Search
                    </div>
                </button>
            </form>
        </div>
        <div class="w-full min-h-[70vh] bg-white p-0 rounded-[10px] drop-shadow overflow-clip">
            <div class="relative overflow-x-auto shadow-xs border border-default">
                <table class="w-full text-sm text-left rtl:text-right text-body">
                    <thead class="text-sm text-body border-b border-default bg-stone-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                User
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Comment
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Blog
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)                            
                            <tr class="bg-neutral-primary border-b border-default">
                                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div id="filled" class="h-16 w-16 flex flex-shrink-0 flex-col bg-stone-200 items-center justify-center rounded-circle overflow-clip">
                                            @if ($comment->user->image)
                                            <img src="{{ asset($comment->user->image) }}" class="h-16 w-16" style="object-fit: cover">
                                            @else
                                            <p class="m-0">no image</p>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="/Dashboard/User/info/{{ $comment->user->id }}">
                                                {{ $comment->user->name }}
                                            </a>
                                            <p class="m-0">{{ $comment->user->email }}</p>
                                        </div>
                                    </div>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $comment->text }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $comment->blog->title }}
                                </td>
                                <td class="px-6 py-4 justify-between flex">
                                    <form action="{{ route('delete.Comment', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button 
                                        type="submit"
                                        onclick="return confirm('Delete this comment?')"
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
        
        <div class="my-10 flex justify-end">
            {{ $comments->links() }}
        </div>

        <div class="w-full min-h-[70vh] bg-white p-5 rounded-[5px] drop-shadow">
            <div class="flex justify-between mb-10">
                <h2>Blog Comments</h2>
                <button class="get-pdf bg-[#5F9598] text-white py-1 px-3 rounded-[10px]">Get PDF</button>
            </div>
            <canvas class="dashboard-content" id="Chart"></canvas>

        </div>
    </div>
</x-dashboardLayout>