@extends('layouts.user')

@section('title', 'Ang Simbahan ng Pateros')

@section('content')
<!-- Main Content -->
<main class="flex-grow">
    <!-- Hero Section with Decorative Elements -->
    <div class="relative h-[500px]">
        <img src="{{ asset('images/church-bg.jpg') }}" alt="Simbahan ng Pateros" class="absolute inset-0 w-full h-full object-cover brightness-50" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/70"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-1 bg-[#b8860b] rounded-full mr-4"></div>
                <i class="fas fa-church text-4xl text-[#b8860b]"></i>
                <div class="w-16 h-1 bg-[#b8860b] rounded-full ml-4"></div>
            </div>
            <h1 class="text-6xl md:text-7xl font-bold mb-4 tracking-wider font-['Rowdies'] text-shadow-lg">
                ANG SIMBAHAN NG PATEROS
            </h1>
            <p class="text-xl max-w-2xl mx-auto text-white/90 mt-4">Alamin ang mayamang kasaysayan at kahalagahan ng ating simbahan</p>
            <div class="mt-8 animate-bounce">
                <a href="#content" class="text-white hover:text-[#b8860b] transition-colors">
                    <i class="fas fa-chevron-down text-2xl"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Decorative Divider -->
    <div class="relative h-16 bg-[#0d5c2f] overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="h-full w-full bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCI+CjxyZWN0IHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgZmlsbD0id2hpdGUiPjwvcmVjdD4KPHBhdGggZD0iTTAgMzBDMTUgMTUgMTUgNDUgMzAgMzBTNDUgMTUgNjAgMzBDNDUgNDUgNDUgMTUgMzAgMzBTMTUgNDUgMCAxNSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZmZmZmZmIiBzdHJva2Utd2lkdGg9IjIiPjwvcGF0aD4KPC9zdmc+')]"></div>
        </div>
        <div class="container mx-auto h-full flex items-center justify-center">
            <div class="flex items-center space-x-4 text-white">
                <i class="fas fa-home"></i>
                <a href="{{ route('home') }}" class="hover:text-[#b8860b] transition-colors">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span>Ang Simbahan ng Pateros</span>
            </div>
        </div>
    </div>

    <!-- Simbahan Content Section -->
    <div id="content" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <!-- History Section with First Image -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-[#0d5c2f]/10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 -mb-6 -ml-6 bg-[#b8860b]/10 rounded-full"></div>

                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-history text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>

                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8 relative z-10">KASAYSAYAN</h2>

                <div class="md:flex items-center gap-8 mb-6">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <img src="{{ asset('images/SIMBAHAN1.JPG') }}" alt="Simbahan ng Pateros Historical Photo" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                        <p class="text-sm text-center mt-2 text-gray-500 italic">Makasaysayang larawan ng Simbahan ng Pateros</p>
                    </div>
                    <div class="md:w-1/2">
                        <p class="text-gray-700 text-lg mb-4 relative z-10">Ang Simbahan ng Pateros ay itinatag ng mga Agustinong Pari bilang Visita ng Pasig taong 1572 at ito ay naging Parokya sa Pamamatnubay ni San Roque noong ika-1 Hunyo taong 1815.</p>
                        <p class="text-gray-700 text-lg mb-4 relative z-10">Ipinagawa naman ni Padre Raymundo Martinez ang kampanang ipinangalan kay San Isidro Labrador taong 1821.</p>
                        <p class="text-gray-700 text-lg mb-4 relative z-10">Naging saksi ang simbahan sa noo'y Rebolusyon ng Pilipinas laban sa mga mananakop na Kastila at naging pansamantalang kwartel ni Heneral Emilio noong ika 1-2 ng Enero taong 1897.</p>
                        <p class="text-gray-700 text-lg mb-4 relative z-10">Sa panahon ng ikalawang digmaang pandaigdig, naging saksi ang Parokya ni San Roque sa pagitan ng labanan ng mga Pilipinong Katipunero at Hukbo ng mga Hapon.</p>
                        <p class="text-gray-700 text-lg mb-4 relative z-10">Matapos ang ikalawang digmaang pandaigdig ay muling bumangon ang mamamayan ng Pateros gayundin ang simbahan nito.</p>
                    </div>
                </div>

            </div>

            <!-- Recent History Section with Second Image -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0d5c2f] to-transparent"></div>

                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-landmark text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>

                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">KASALUKUYANG KASAYSAYAN</h2>

                <div class="max-w-3xl mx-auto">
                    <p class="text-gray-700 text-lg mb-6">Mula sa kinabibilangan nito sa Archdiyosesis ng Maynila, ito ay napasailalim sa Diyosesis ng Pasig dahil sa pagkakatatag nito noong Agosto 21, 2003.</p>

                    <div class="md:flex items-center gap-8 my-8">
                        <div class="md:w-1/2 order-2 md:order-1">
                            <p class="text-gray-700 text-lg mb-4">Taong 2009, sa masidhing debosyon at panalangin ng mananamapalatayang tiga-Pateros, ang ating Parokya ay iniluklok bilang Dambanang Pandiyosesis ni Santa Marta ang ating Pintakasi at Rosas ng Pateros. Ito ay sa pamumuno ng unang Rektor ng Dambana at Kura Paro Reb. Padre Orlando B. Cantillon</p>
                        </div>
                        <div class="md:w-1/2 mb-6 md:mb-0 order-1 md:order-2">
                            <img src="{{ asset('images/SIMBAHAN2.JPG') }}" alt="Simbahan ng Pateros Interior" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                            <p class="text-sm text-center mt-2 text-gray-500 italic">Ang magandang loob ng Simbahan ng Pateros</p>
                        </div>
                    </div>

                    <p class="text-gray-700 text-lg mb-6">Nito lamang 2015 sa Pamumuno ng ating ikalawang Rektor ng Dambana at Kura Paroko Reb. Padre Roy M. Rosales ay ipinagdiwang ng Parokya ni San Roque ang ika-200 pagkakatatag nito bilang isang Parokya. Ito ang pasasalamat ng mananampalataya sa biyayang ipinagkaloob sa nagdaang 200 daang taon at sa mga taong darating pa.</p>
                    <p class="text-gray-700 text-lg mb-6">Sa kasalukuyan, ang ating simbahan ay pinamumunuan ng ating ngayo'y Rektor ng Dambana at Kura Paroko Reb. Padre Loreto "Jhun" Sanchez, Jr. Ang bawat pagkilos ng organisasyon ay nakapaloob sa 'vision' at misyon ng ating Parokya:</p>
                </div>
            </div>

            <!-- Vision & Mission Section with Third Image -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div class="bg-gray-50 rounded-xl shadow-lg p-8 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="flex items-center justify-center mb-8">
                        <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                        <i class="fas fa-eye text-3xl text-[#0d5c2f]"></i>
                        <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                    </div>

                    <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">VISION</h2>

                    <div class="mb-6">
                        <img src="{{ asset('images/SIMBAHAN3.JPG') }}" alt="Simbahan ng Pateros Exterior" class="w-full h-auto rounded-lg shadow-lg mb-6 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                        <p class="text-sm text-center mb-6 text-gray-500 italic">Ang magandang arkitektura ng ating simbahan</p>
                    </div>

                    <p class="text-gray-700 text-lg mb-6 italic border-l-4 border-[#b8860b] pl-6 py-2">Pinapangako namin ang maging isang pamayanan na mga alagad ni Kristo na hinuhubog ng Espiritu Santo tungo sa pagpapalaganap ng kaharian ng Diyos sa pagkakandili ng Birheng Maria at ng Mahal na Patrong San Roque at Santa Marta.</p>
                </div>

                <div class="bg-gray-50 rounded-xl shadow-lg p-8 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                    <div class="flex items-center justify-center mb-8">
                        <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                        <i class="fas fa-bullseye text-3xl text-[#0d5c2f]"></i>
                        <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                    </div>

                    <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">MISSION</h2>

                    <div class="mb-6">
                        <img src="{{ asset('images/SIMBAHAN4.jpg') }}" alt="Simbahan ng Pateros Community" class="w-full h-auto rounded-lg shadow-lg mb-6 transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                        <p class="text-sm text-center mb-6 text-gray-500 italic">Ang masigla at matatag na pamayanan ng Simbahan ng Pateros</p>
                    </div>

                    <ol class="list-decimal pl-6 space-y-2 text-gray-700">
                        <li>Ang kahalagahan ng pagpapahayag ng Salita ng Diyos at ang pagdiriwang ng Sakramento sa pagkakaisa ng pamayanan;</li>
                        <li>Ang tuloy-tuloy at ganap na paghuhubog sa pananampalataya sa lahat ng pamunuan at kasapi ng mga pamayanan;</li>
                        <li>Ang pagpapalaganap ng malalim na pagkakapatiran, pananagutan at pagmamalasakitan upang maging simbahan ng mga dukha;</li>
                        <li>Ang pagbabatid ng mga lingkuran ng simbahan, pari at layko sa sitwasyon at buhay pamayanan;</li>
                        <li>Ang pagbibigay prioridad sa pagtatag at pangangalaga ng mga Parish Pastoral Units (PPU's);</li>
                        <li>Ang pagpapahalaga sa partisipasyon ng mga kabataan sa simbahan;</li>
                        <li>Ang pangangalaga sa dignidad ng pamilya at pagpapalaganap din ng apostolado ng pamilya;</li>
                        <li>Ang pagpapahalaga sa ating kapaligiran, kalikasan at ekolohiya.</li>
                    </ol>
                </div>
            </div>

            <!-- Removed the separate gallery section and integrated images within the content above -->
        </div>
    </div>
</main>
@endsection
