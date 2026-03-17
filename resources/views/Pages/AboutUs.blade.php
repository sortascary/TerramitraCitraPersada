<x-layout>
    @vite('resources/css/about.css')
    @vite(['resources/js/about.js'])
    <main class="pt-20 px-10 mb-10" style="max-width: 1200px; margin: 0 auto">

        <div class="mt-30 relative">
            <div id="imageContainer">
                <img id="myImage" src="images/indonesiaMap.jpg">
            </div>
            <div class="mb-10">
                <x-Title>About us</x-Title>
            </div>
    
            <div class="flex justify-evenly mb-40">
                <p style="font-size: 20px; margin-right: 30px; z-index: 2"><mark style="background: white"> Terramitra Citra Persada didirikan pada tahun 2020 merupakan perusahaan nasional bergerak di bidang 
                jasa konsultan dalam memberikan solusi pengelolaan sumberdaya alam berbasiskan teknologi digital.</mark></p>
            </div>
        </div>

        

        <div class="my-8">
            <x-Title>Management</x-Title>
        </div>

        <div class="row gap-4 mb-10 justify-center">
            <div class="drop-shadow-lg managementItem col-md-5">
                <img style="width: 100px;height: 100px;border-radius: 50%; display: inline; background-color: grey" src="Profiles/User.png">
                <br></br>
                <h2>Anna Yoske Susari</h2>
                <h2>Direktur Utama</h2>
            </div>
            <div class="drop-shadow-lg managementItem col-md-5">
                <img style="width: 100px;height: 100px;border-radius: 50%; display: inline; background-color: grey" src="Profiles/User.png">
                <br></br>
                <h2>Tossan Aditya Azhar</h2>
                <h2>Komisaris Utama</h2>
            </div>
            <div  class="drop-shadow-lg managementItem col-md-5">
                <img style="width: 100px;height: 100px;border-radius: 50%; display: inline; background-color: grey" src="Profiles/User.png">
                <br></br>
                <h2>R. Yustiono</h2>
                <h2>Direktur</h2>
            </div>
            <div class="drop-shadow-lg managementItem col-md-5">
                <img style="width: 100px;height: 100px;border-radius: 50%; display: inline; background-color: grey" src="Profiles/User.png">
                <br></br>
                <h2>San San </h2>
                <h2>Komisaris</h2>
            </div>  

        </div>

    </main>

    <x-footer></x-footer>
</x-layout>