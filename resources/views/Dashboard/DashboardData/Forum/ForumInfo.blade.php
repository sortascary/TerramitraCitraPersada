<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Forums</h1>
    </div>

    <div class="p-4">

        <button onclick="location.href='/Dashboard/Forum'" class="pb-4">
            <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
            </svg>
        </button>
        
        <div class="flex justify-between mb-3 items-cent">
            <a href="/Dashboard/Forum/edit/{{ $forum->id }}" class="inline-flex items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2">
                <div class="text-white bg-[#1D546D] px-3 py-2.5 h-full rounded-2 ">
                    Edit Forum
                </div>
            </a>
            <div class="h-full flex ">
                <form method="POST" action="{{ route('delete.Chat', $forum->id) }}" class="flex px-2 h-full items-center space-x-2">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Clear this chat?')" type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2 focus:outline-none">
                        <div class="text-white bg-red-500 px-3 h-full py-2.5 rounded-2 items-center justify-center flex">
                            Clear Chat
                        </div>
                    </button>
                </form>
                <form method="POST" action="{{ route('delete.Forum', $forum->id) }}" class="flex px-2 h-full items-center space-x-2">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Delete this Forum?')" type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2 focus:outline-none">
                        <div class="text-white bg-red-500 px-3 h-full py-2.5 rounded-2 items-center justify-center flex">
                            Delete Forum
                        </div>
                    </button>
                </form>

            </div>
        </div>

        <div class="flex justify-center overflow-x-scroll mb-3 px-5">

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Messages</p>
                <p>{{ $forum->messageforum->count() }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Messages Today</p>
                <p>{{ $forum->messageforum->where('created_at', \Carbon\Carbon::today())->count() }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Users</p>
                <p>{{ $forum->users->count() }}</p>
            </div>

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Polls</p>
                <p>0</p>
            </div>

        </div>

        <div class="w-full min-h-[70vh] bg-white p-5 rounded-[5px] drop-shadow">
            <div class="flex justify-between mb-10">
                <h2>Forum Messages</h2>
                <button class="get-pdf bg-[#5F9598] text-white py-1 px-3 rounded-[10px]">Get PDF</button>
            </div>
            <canvas class="dashboard-content" id="Chart"></canvas>

        </div>
    </div>
    @vite(['resources/js/Chart.js'])
    <script>
        window.chartLabels = @json($messages->pluck('date'));
        window.chartValues = @json($messages->pluck('total'));
        window.chartLabelName = 'Messages';
    </script>
</x-dashboardLayout>