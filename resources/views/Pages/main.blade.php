<x-layout>
    @vite('resources/css/home.css')
    @vite(['resources/js/hero.js'])
    @vite(['resources/js/home.js'])

    <div class="Hero">
      <canvas id="bg"></canvas>
      <div class="overlay">
        <h1 class="font-bold" id="HeroTitle">PT. TERRAMITRA CITRA PERSADA</h1>
        <p>REMOTE SENSING AND GIS COMPANY</p>
      </div>
    </div>

    <div class="blur-line"></div>
    <div class="text-center flex flex-column item-center justify-center pt-30 pb-60 z-2 relative overflow-hidden" style="background-color: white" >
      <h1>Menyajikan data langsung kepada Anda!</h1>
      <p class="mx-auto max-w-120 text-center">
        Kami menangani proses survei, pengumpulan data, dan analisis data untuk mendukung pengambilan keputusan yang lebih baik dalam industri pengumpulan sumber daya.
      </p>
    </div>


    {{-- visi & misi small --}}
    <div class=" d-lg-none">
      <div class="flex justify-between items-center row px-5" style="border-top: 2px solid rgb(226, 226, 226)">
        <img src="/images/Visi.jpg" class="col-lg-6 h-20vh" style="object-fit: cover;">
        <div class="col-lg-6 p-20">
          <x-Title>Visi</x-Title>
          <p>Perusahaan swasta nasional yang bergerak di bidang penyediaan Informasi Geospasial dan
              Pengembangan Sumberdaya Manusia yang terpercaya.
          </p>
        </div>
      </div>
      <div class="row flex justify-between items-center mb-20 px-5"  style="border-bottom: 2px solid rgb(226, 226, 226)">
        <img src="/images/Misi.jpg" class="col-lg-6 h-20vh" style="object-fit: cover;">
        <div class="col-lg-6 p-20">
          <x-Title>Misi</x-Title>
          <p>Komitmen terhadap kualitas hasil pekerjaan dan ketepatan waktu kepada pelanggan.</p>
        </div>
      </div>
    </div>

    {{-- Visi & Misi large --}}
    <div class="row mb-20 d-none d-lg-flex">
      <div class=" justify-between items-center col-6 p-0" style="border-top: 2px solid rgb(226, 226, 226); border-bottom: 2px solid rgb(226, 226, 226)">
        <div class=" px-10 h-dvh flex flex-column justify-center relative">
          <img src="/images/Decoration/Asset2.png" class="w-full absolute bottom-0 opacity-[25%]">
          <div class="relative" style="line-height: 80px">
            <x-Title>Visi</x-Title>
          </div>
          <h3>Perusahaan swasta nasional yang bergerak di bidang penyediaan Informasi Geospasial dan
              Pengembangan Sumberdaya Manusia yang terpercaya.
          </h3>
        </div>
        <div class=" px-20 h-dvh flex flex-column justify-center relative">
          <img src="/images/Decoration/Asset3.png" class="w-full absolute bottom-0 opacity-[25%]">
          <div class="relative text-[80px]" >
            <x-Title>Misi</x-Title>
          </div>
          <h3>Komitmen terhadap kualitas hasil pekerjaan dan ketepatan waktu kepada pelanggan.</h3>
        </div>
      </div>
      
      <div id="images" class="justify-between items-center p-0 col-6 ">      
        
        <div class="h-dvh relative overflow-clip">
          <div style="height:300dvh;position: absolute;top:-100dvh">
            <div style="position: sticky;top:0;">
              <img  src="/images/Visi.jpg" class="h-dvh" style="object-fit: cover;" >
            </div> 
          </div>
        </div>

        <div class="h-dvh relative overflow-clip">
          <div style="height:300dvh;position: absolute;top:-100dvh">
            <div style="position: sticky;top:0;">
              <img  src="/images/Misi.jpg" class="h-dvh" style="object-fit: cover;">
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="frame py-20 px-10 border-4 border-[#09F000] drop-shadow-lg bg-white rounded-lg flex flex-col items-center" style="max-width: 1200px; margin: 30px auto">
      
      <img src="/images/Decoration/Asset1.png" class="w-full absolute bottom-0">
      <div class="mb-20 ">
        <x-Title>Recent Blogs</x-Title>
      </div>
      <div class="row justify-center w-full">
        @foreach ($blogs as $blog)            
            <div class="col-lg-4 col-6 m-0 p-2 flex relative bg-white" style="height: 300px; width:300px; overflow:hidden;">
              
              <div class="w-full h-full">
                @if ($blog->contentAttachments->isNotEmpty())
                    <img
                        src="{{ asset($blog->contentAttachments->first()->file) }}"
                        class="object-cover h-full w-full"
                    >
                @endif
                <div class='BlogOverlay'>
                  <div class="flex justify-between">
                    <div>
                      <h2>{{$blog->title}}</h2>
                      <p>{{DATE_FORMAT($blog->created_at, 'd M Y ')}}</p>
                    </div>
                    <a href="/Blog/{{ $blog->id }}" class="BlogLink flex h-fit">
                      <span class="flex p-2 text-white items-center justify-center">
                        
                        <svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M5.027 10.9a8.729 8.729 0 0 1 6.422-3.62v-1.2A2.061 2.061 0 0 1 12.61 4.2a1.986 1.986 0 0 1 2.104.23l5.491 4.308a2.11 2.11 0 0 1 .588 2.566 2.109 2.109 0 0 1-.588.734l-5.489 4.308a1.983 1.983 0 0 1-2.104.228 2.065 2.065 0 0 1-1.16-1.876v-.942c-5.33 1.284-6.212 5.251-6.25 5.441a1 1 0 0 1-.923.806h-.06a1.003 1.003 0 0 1-.955-.7A10.221 10.221 0 0 1 5.027 10.9Z"/>
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
      </div>
    </div>

    <div class="hidden lg:flex my-30 overflow-hidden flex-column">
      <div class="self-center">
        <x-Title>Trusted by</x-Title>
      </div>
      <div class="scroll py-20 bg-white w-[100vw] flex items-center overflow-hidden">
        <ul class="flex m-0 w-[150vw] scrolling justify-between gap-[20px]">
          @foreach ($clients as $client)
          <li class="flex items-center">
            <img src="{{ asset($client->image) }}" alt="" class="w-[100%] object-contain" style="width: 400px">
          </li>
          @endforeach
        </ul>
        <ul aria-hidden="true" class="flex m-0 w-[150vw] scrolling justify-between gap-[20px]">
          @foreach ($clients as $client)
          <li class="flex items-center">
            <img src="{{ asset($client->image) }}" alt="" class=" object-contain" style="width: 400px">
          </li>
          @endforeach
        </ul>
      </div>
    </div>
    
  <x-footer></x-footer>
</x-layout>