<x-dashboardLayout>
    <script>
        window.chartLabels = @json($messages->pluck('date'));
        window.chartValues = @json($messages->pluck('total'));
        window.chartLabelName = 'Total Messages';
    </script>
    @vite(['resources/js/chart.js'])

    <div class="bg-white p-2 w-full">
        <h1 class="w-full">Dashboard</h1>
    </div>

    <div class="p-4">
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
        </div>
        <div class="w-full min-h-[70vh] bg-white p-5 rounded-[5px] drop-shadow">
            <div class="flex justify-between mb-10">
                <h2>Forum Messages</h2>
                <button class="get-pdf bg-[#5F9598] text-white py-1 px-3 rounded-[10px]">Get PDF</button>
            </div>
            <canvas class="dashboard-content " id="Chart"></canvas>

        </div>
    </div>
</x-dashboardLayout>