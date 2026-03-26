<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Clients</h1>
    </div>

    <div class="p-4">
        <p>List of Clients</p>
        
        <div class="bg-white w-full mx-2 my-5 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
            <p>Total Clients</p>
            <p>{{ $clientCount }}</p>
        </div>
        
        <div class="flex justify-between mb-3 items-cent">            
            <form method="GET" action="#" class="flex items-center w-full space-x-2">
                <div class="relative col-5">
                    <input type="text" name="search" value="{{ request('search') }}" id="simple-search" class="px-3 py-2.5 bg-white border-black border rounded-[5px] ps-9 text-heading text-sm focus:ring-brand focus:border-brand block w-full placeholder:text-body" placeholder="Search Client name..." required />
                </div>
                <button type="submit" class="inline-flex  h-full items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2 focus:outline-none">
                    <div class="text-white bg-[#0084C0] px-3 h-full rounded-2 items-center justify-center flex">
                        Search
                    </div>
                </button>
            </form>
            <a href="/Dashboard/Client/add" class="inline-flex items-center justify-center shrink-0 focus:ring-4 focus:ring-brand-medium shadow-xs rounded-2">
                <div class="text-white bg-[#5F9598] px-3 py-2.5 h-full rounded-2 ">
                    +Add Client
                </div>
            </a>
        </div>

        <div class="row">
            @foreach ($clients as $client)                
                <div class="bg-white w-full p-3 flex justify-between rounded-[10px] drop-shadow my-3">
                    <div class="flex items-center">
                        <img src="{{ asset($client->image) }}" alt="Client Logo" class="bg-stone-200 " style="width: 100px; height: 100px; object-fit: cover;">

                        <div class="ml-3">
                            <h3 class="mb-0">{{ $client->name }}</h3>
                        </div>
                    </div>
                    <div class="flex ">
                        <a href="/Dashboard/Client/edit/{{ $client->id }}">
                            <div>
                                <svg class="w-7 h-7 text-gray-800 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                </svg>
                            </div>
                        </a>
                        <a href="#">
                            <form action="{{ route('delete.Client', $client->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')

                                <button 
                                    type="submit"
                                    onclick="return confirm('Delete this client?')"
                                >
                                    <svg class="w-7 h-7 text-gray-800 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                    </svg>
                                </button>
                            </form>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="my-10 flex justify-end">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
</x-dashboardLayout>