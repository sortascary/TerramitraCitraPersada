<x-layout>
    @vite('resources/css/services.css')
    @vite(['resources/js/services.js'])
    <main class="pt-20" style="max-width: 1200px; margin: 0 auto; min-height: 100vh">
        <div style="display: flex; align-items: center; justify-content: space-between;padding: 30px 20px">
            <x-Title>Services</x-Title>
            <form method="GET">
                <select name="type" onchange="this.form.submit()" style="background-color: white; border: 2px solid black">
                    <option value="Data" {{ request('type') === 'Data' ? 'selected' : '' }} selected>Data & Software</option>
                    <option value="PemetaanDasar" {{ request('type') === 'PemetaanDasar' ? 'selected' : '' }}>Pemetaan Dasar</option>
                    <option value="PemetaanTematik" {{ request('type') === 'PemetaanTematik' ? 'selected' : '' }}>Pemetaan Tematik</option>
                    <option value="Survey" {{ request('type') === 'Survey' ? 'selected' : '' }}>Survey</option>
                    <option value="Training" {{ request('type') === 'Training' ? 'selected' : '' }}>Training</option>
                </select>
            </form>
        </div>
        
        <div style="background-color: white;display: flex;flex-direction: column; justify-content: center;align-items: center" class="p-5 mb-50">
            @if (request('type') === 'Data')
                <x-ServiceData></x-ServiceData>
            @elseif (request('type') === 'PemetaanDasar')
                <x-ServiceDasar></x-ServiceDasar>
            @elseif (request('type') === 'PemetaanTematik')
                <x-ServiceTematik/>
            @elseif (request('type') === 'Survey')
                <x-ServiceSurvey/>
            @elseif (request('type') === 'Training')
                <x-ServiceTraining/>
            @else
                <x-ServiceData></x-ServiceData>
            @endif
        </div>
    </main>
    <x-footer></x-footer>
</x-layout>