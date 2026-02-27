<x-dashboardLayout>
            <script>
                window.chartLabels = @json($logins->pluck('date'));
                window.chartValues = @json($logins->pluck('total'));
                window.chartLabelName = 'User Logins';
            </script>
    @vite(['resources/js/chart.js'])

    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Dashboard</h1>
    </div>

    <div class="p-4">

        <div class="flex overflow-x-scroll my-5 justify-evenly">
            <div class="bg-white flex col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] items-center">
                <div class="h-full p-3 aspect-square bg-[#1D546D] items-center justify-center flex rounded-[20px]">
                    <svg class="w-7 h-7 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
                   </svg>
                </div>
                <div class="font-semibold">
                    <p class="m-0 text-xl">Total Users</p>
                    <p class="m-0 text-xl">{{$userCount}}</p>
                </div>
            </div>
            <div class="bg-white flex col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] items-center">
                <div class="h-full p-3 aspect-square bg-[#1D546D] items-center justify-center flex rounded-[20px]">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="font-semibold">
                    <p class="m-0 text-xl">Total Blogs</p>
                    <p class="m-0 text-xl">{{$contentCount}}</p>
                </div>
            </div>
            <div class="bg-white flex col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] items-center">
                <div class="h-full p-3 aspect-square bg-[#1D546D] items-center justify-center flex rounded-[20px]">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M4 3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h1v2a1 1 0 0 0 1.707.707L9.414 13H15a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M8.023 17.215c.033-.03.066-.062.098-.094L10.243 15H15a3 3 0 0 0 3-3V8h2a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-1v2a1 1 0 0 1-1.707.707L14.586 18H9a1 1 0 0 1-.977-.785Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="font-semibold">
                    <p class="m-0 text-xl">Total Forums</p>
                    <p class="m-0 text-xl">{{$forumCount}}</p>
                </div>
            </div>
            <div class="bg-white flex col-3 m-2 p-3 drop-shadow gap-2 rounded-[5px] items-center">
                <div class="h-full p-3 aspect-square bg-[#1D546D] items-center justify-center flex rounded-[20px]">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-6.616l-2.88 2.592C8.537 20.461 7 19.776 7 18.477V17H5a2 2 0 0 1-2-2V6Zm4 2a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2H7Zm8 0a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2h-2Zm-8 3a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm5 0a1 1 0 1 0 0 2h5a1 1 0 1 0 0-2h-5Z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="font-semibold">
                    <p class="m-0 text-xl">Total Comments</p>
                    <p class="m-0 text-xl">{{$commentCount}}</p>
                </div>
            </div>
        </div>
        <div class="w-full min-h-[70vh] bg-white p-5 rounded-[5px] drop-shadow">
            <div class="flex justify-between mb-10">
                <h2>User Activity</h2>
                <button class="bg-[#5F9598] text-white py-1 px-3 rounded-[10px]">Get PDF</button>
            </div>
            <canvas id="Chart"></canvas>

        </div>
    </div>

</x-dashboardLayout>