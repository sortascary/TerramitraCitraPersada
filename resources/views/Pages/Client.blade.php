<x-layout>
    @vite('resources/css/client.css')
    <main class="pt-20 px-10" style="text-align: center; max-width: 1200px; margin: 0 auto">
        <div class="mt-30 mb-10">
            <x-Title>Clients</x-Title>
        </div>

        <div class="flex flex-column mt-10 mb-50" style="justify-content: center">
            @foreach ($clients->chunk(4) as $clientRow)
                <div class="row {{ $loop->odd ? 'pl-lg-10 justify-end' : 'pr-lg-10'  }}">
                    @foreach ($clientRow as $client)
                        <div class="col-lg-3 col-md-4 col-6 p-3" style="border: 1px solid black;">
                            <img
                                src="{{ $client->image }}"
                                style="object-fit: contain; width: 100%; height: 150px;"
                            >
                            <h2>{{ $client->name }}</h2>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
    </main>
    <x-footer></x-footer>
</x-layout>