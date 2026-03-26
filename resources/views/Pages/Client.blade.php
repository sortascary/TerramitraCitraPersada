<x-layout>
    @vite('resources/css/client.css')
    <main class="pt-20 px-10 " style="text-align: center; max-width: 1200px; margin: 0 auto">
        <div class="mt-30 mb-10">
            <x-Title>Clients</x-Title>
        </div>

        <div class="flex flex-column mt-10 mb-50" style="justify-content: center">
            @foreach ($clients->chunk(4) as $clientRow)
                <div class="flex flex-wrap items-stretch py-2 {{ $loop->odd ? 'pl-lg-10 justify-end' : 'pr-lg-10'  }}">
                    @foreach ($clientRow as $client)
                    <div class="col-lg-3 col-md-4 col-6 flex flex-col p-2">
                        <div class="p-3 rounded-lg bg-white drop-shadow flex flex-col h-full {{ $loop->parent->odd ? 'fromRight' : 'fromLeft'  }}">
                            <img
                                src="{{ $client->image }}"
                                class="h-20"
                                style="object-fit: contain; width: 100%;"
                            >
                            <p class="font-bold lg:text-3xl text-base self-center">{{ $client->name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach

        </div>
    </main>
    <x-footer></x-footer>
</x-layout>