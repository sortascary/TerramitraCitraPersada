<x-layout>
    @vite('resources/css/services.css');
    <main class="py-20 px-10" style="max-width: 1200px; margin: 0 auto; min-height: 100vh">
        <div style="display: flex; align-items: center; justify-content: space-between;padding: 30px 20px">
            <x-Title>Blog</x-Title>
            <form method="GET">
                <label for="sort">Sort by:</label>
                <select name="sort" onchange="this.form.submit()" style="background-color: white; border: 2px solid black">
                    <option value="Latest" {{ request('sort') === 'Latest' ? 'selected' : '' }}>Latest</option>
                    <option value="Oldest" {{ request('sort') === 'Oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="Popular" {{ request('sort') === 'Popular' ? 'selected' : '' }}>Popular</option>
                </select>
            </form>
            
        </div>
        
        <div class="row">
            @foreach ($blogs as $blog)
                <a href="/Blog/{{ $blog->id }}" class="col-lg-4 col-md-6 mb-10 px-2">
                    <div class="drop-shadow p-4" style="background-color: white">
                        <div class="h-[200px] w-full object-cover bg-stone-400">
                            @if ($blog->contentAttachments->isNotEmpty())
                                <img
                                    src="{{  asset($blog->contentAttachments->first()->file) }}"
                                    class="h-[200px] w-full object-cover"
                                >
                            @endif

                        </div>
                        <h2>{{$blog->title}}</h2>
                        <p>{{ Str::limit($blog->desc, 145) }}</p>    
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-10 flex justify-end">
            {{ $blogs->links() }}
        </div>
    </main>
    <x-footer></x-footer>
</x-layout>