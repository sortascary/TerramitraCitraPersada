<x-dashboardLayout>
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Clients</h1>
    </div>

    <div class="p-4">
        <p>Edit Client</p>

        <div class="bg-white h-[80vh] p-5">
            <button onclick="history.back()" class="pb-4">
                <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
            </button>
            <form id="form" action="{{ route('edit.Client', $client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Client Name</label>
                    <input type="text" name="name" id="name" value="{{ $client->name }}" class="bg-gray-50 border border-black text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Company Name" >
                </div>
                <div class="my-3">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Company Logo</label>
                    <label for="image" class="flex flex-col items-center justify-center w-full h-64 border border-black border-default-strong rounded-lg cursor-pointer hover:bg-stone-200">
                        <div id="empty" class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2"/></svg>
                            <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <div id="filled" class="hidden flex flex-col items-center justify-center text-body pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                            </svg>
                            <p id="file-name" class="text-sm mt-2 text-gray-600"></p>
                            <p class="text-xs">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="image" name="image" type="file" class="hidden" value="{{ asset($client->image) }}"/>
                    </label>
                </div> 
                <div class="bg-[#1D546D] hover:bg-[#184458] focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg">
                    <button id="submitBtn" type="submit" class="w-full text-white font-medium text-sm px-5 py-2.5 text-center">Save</button>
                </div>
                
                @if ($errors->any())
                  <ul class="p-0">
                    @foreach ($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                  </ul>
                @endif
            </form>
        </div>
    </div>
    @vite(['resources/js/forms.js'])
</x-dashboardLayout>