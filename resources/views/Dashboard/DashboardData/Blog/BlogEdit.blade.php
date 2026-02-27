<x-dashboardLayout>
    <script>
        window.chartLabels = @json($views->pluck('date'));
        window.chartValues = @json($views->pluck('total'));
        window.chartLabelName = 'Views';
    </script>
    @vite(['resources/js/chart.js'])
    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Blogs</h1>
    </div>

    <div class="p-4">
        <p>Edit Blog</p>

        <div class="flex overflow-x-scroll  mb-3 px-5">

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

            <div class="bg-white col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] text-[#1D546D] font-semibold text-center">
                <p>Total Comments</p>
                <p>{{ $CommentCount }}</p>
            </div>

        </div>

        <div class="bg-white h-[80vh] p-5">
            <button onclick="history.back()" class="pb-4">
                <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                </svg>
            </button>
            <form id="form" action="{{ route('edit.Blog', $blog->id) }}" method="POST" enctype="multipart/form-data" class="row w-full">
                @csrf
                <div class="col-8">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                        <input type="text" name="title" id="title" value="{{ $blog->title }}" class="bg-gray-50 border border-black text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Blog Name" required>
                    </div>
                    <div>
                        <label for="desc" class="block mb-2 text-sm font-medium text-gray-900">Content</label>
                        <textarea 
                            class="mb-3 bg-gray-50 border border-black text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            rows="3"
                            placeholder="Write contents..."
                            id="desc" 
                            name="desc"
                        >{{ old('desc', $blog->desc) }}</textarea>
                    </div>
                </div>
                <div class="mb-3 col-4">
                    <label for="images" class="block mb-2 text-sm font-medium text-gray-900">Company Logo</label>
                    <div class="flex flex-col w-full min-h-64 border border-black border-default-strong rounded-lg p-3">

                        <label for="images" class="items-center justify-center w-full p-2 border border-black border-default-strong rounded-lg cursor-pointer hover:bg-stone-200">
                            <div id="empty" class="flex flex-col items-center justify-center text-body h-full">
                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                                </svg>
                            </div>
                            <input id="images" name="images[]" type="file" class="hidden" accept="image/*" multiple/>
                        </label>

                        <div id="oldFileList" class="flex flex-col gap-2 my-2">
                            @foreach($Attachments as $attachment)
                                @if ($attachment)
                                    <div class="bg-stone-200 flex items-center p-2 rounded-lg existing-file">
                                        <button type="button" onclick="removeExisting(this)" >
                                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                            </svg>
                                        </button>

                                        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z" clip-rule="evenodd"/>
                                        </svg>

                                        <input type="hidden" name="existing_images[]" value="{{ $attachment->id }}">

                                        <p class="m-0 text-sm">{{ basename($attachment->file) }}</p>

                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div id="fileList" class="flex flex-col gap-2 my-2">
                            
                        </div>
                        

                    </div>
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

        <div class="w-full min-h-[70vh] bg-white my-4 p-5 rounded-[5px] drop-shadow">
            <div class="flex justify-between mb-10">
                <h2>Blog Views</h2>
                <button class="bg-[#5F9598] text-white py-1 px-3 rounded-[10px]">Get PDF</button>
            </div>
            <canvas id="Chart"></canvas>

        </div>

    </div>
    <script>
        const input = document.getElementById('images');
        const fileList = document.getElementById('fileList');
        const oldFileList = document.getElementById('oldFileList');

        let storedFiles = []; // this keeps ALL selected files

        input.addEventListener('change', function () {

            // Add new files to storedFiles
            Array.from(this.files).forEach(file => {
                storedFiles.push(file);
            });

            updateFileInput();
            renderFileList();
        });

        input.addEventListener('load', function () {
            renderFileList();
        });


        function updateFileInput() {
            const dataTransfer = new DataTransfer();

            storedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;
        }

        function renderFileList() {
            fileList.innerHTML = '';

            storedFiles.forEach((file, index) => {

                const wrapper = document.createElement('div');
                wrapper.className = "bg-stone-200 flex n items-center p-2 rounded-lg";

                wrapper.innerHTML = `
                    <button type="button" onclick="removeFile(${index})" >
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                        </svg>
                    </button>

                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z" clip-rule="evenodd"/>
                    </svg>

                    <p class="m-0 text-sm">${file.name}</p>
                `;

                fileList.appendChild(wrapper);
            });
        }

        function removeFile(index) {
            storedFiles.splice(index, 1);
            updateFileInput();
            renderFileList();
        }
        window.removeExisting = function(button) {
            const wrapper = button.closest('.existing-file');
            wrapper.remove();
        }
    </script>
    @vite(['resources/js/forms.js'])
</x-dashboardLayout>