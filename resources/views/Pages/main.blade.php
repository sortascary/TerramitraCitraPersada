<x-layout>
    @vite('resources/css/home.css')
    @vite(['resources/js/hero.js'])
    @vite(['resources/js/visi.js'])

    <div class="Hero">
      <canvas id="bg"></canvas>
      <div class="overlay">
        <h1 class="font-bold" id="HeroTitle">PT. TERRAMITRA CITRA PERSADA</h1>
        <p>REMOTE SENSING AND GIS COMPANY</p>
      </div>
    </div>

    <div class="blur-line"></div>
    <div class="text-center flex flex-column item-center justify-center pt-30 pb-60 z-2 relative" style="background-color: white" >
      <h1>Menyajikan data langsung kepada Anda!</h1>
      <p class="mx-auto max-w-120 text-center">
        Kami menangani proses survei, pengumpulan data, dan analisis data untuk mendukung pengambilan keputusan yang lebih baik dalam industri pengumpulan sumber daya.
      </p>
    </div>


    {{-- visi & misi small --}}
    <div class=" d-lg-none">
      <div class="flex justify-between items-center row px-5" style="border-top: 2px solid rgb(226, 226, 226)">
        <img src="/images/visi.jpg" class="col-lg-6 h-20vh" style="object-fit: cover;">
        <div class="col-lg-6 p-20">
          <x-Title>Visi</x-Title>
          <p>Perusahaan swasta nasional yang bergerak di bidang penyediaan Informasi Geospasial dan
              Pengembangan Sumberdaya Manusia yang terpercaya.
          </p>
        </div>
      </div>
      <div class="row flex justify-between items-center mb-20 px-5"  style="border-bottom: 2px solid rgb(226, 226, 226)">
        <img src="/images/misi.jpg" class="col-lg-6 h-20vh" style="object-fit: cover;">
        <div class="col-lg-6 p-20">
          <x-Title>Misi</x-Title>
          <p>Komitmen terhadap kualitas hasil pekerjaan dan ketepatan waktu kepada pelanggan.</p>
        </div>
      </div>
    </div>

    {{-- Visi & Misi large --}}
    <div class="row mb-20 d-none d-lg-flex">
      <div class=" justify-between items-center col-6 p-0" style="border-top: 2px solid rgb(226, 226, 226); border-bottom: 2px solid rgb(226, 226, 226)">
        <div class=" px-20 h-dvh flex flex-column justify-center">
          <div class="relative" style="line-height: 80px">
            <x-Title>Visi</x-Title>
          </div>
          <h3>Perusahaan swasta nasional yang bergerak di bidang penyediaan Informasi Geospasial dan
              Pengembangan Sumberdaya Manusia yang terpercaya.
          </h3>
        </div>
        <div class=" px-20 h-dvh flex flex-column justify-center">
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
              <img  src="/images/visi.jpg" class="h-dvh" style="object-fit: cover;" >
            </div> 
          </div>
        </div>

        <div class="h-dvh relative overflow-clip">
          <div style="height:300dvh;position: absolute;top:-100dvh">
            <div style="position: sticky;top:0;">
              <img  src="/images/misi.jpg" class="h-dvh" style="object-fit: cover;">
            </div>
          </div>
        </div>
      </div>
    </div>



    
    <div class="py-40 px-10" style="max-width: 1200px; margin: 0 auto">
      <div class="my-10 ">
        <x-Title>Blogs</x-Title>
      </div>
      <div class="row justify-center w-full">
        @foreach ($blogs as $blog)            
            <div class="col-lg-4 col-6 m-0 p-0 flex relative bg-stone-400" style="height: 300px; width:300px; overflow:hidden;">
              
              <a href="/Blog/{{ $blog->id }}" >
                @if ($blog->contentAttachments->isNotEmpty())
                    <img
                        src="{{ asset($blog->contentAttachments->first()->file) }}"
                        class="blogImg"
                    >
                @endif
                <div class='BlogOverlay'>
                  <h2>{{$blog->title}}</h2>
                  <div class="flex h-full justify-center items-center">
                    <div class="BlogLink">
                        <span class="flex px-10 py-2 text-white">

                          <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                          </svg>
                          View
                        </span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
      </div>
    </div>
    
  <x-footer></x-footer>
</x-layout>