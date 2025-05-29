@extends('layouts.user')

@section('title', 'Ang Kaparian')

@section('content')
<!-- Main Content -->
<main class="flex-grow">
    <!-- Hero Section with Decorative Elements -->
    <div class="relative h-[500px]">
        <img src="{{ asset('images/church-bg.jpg') }}" alt="Ang Kaparian" class="absolute inset-0 w-full h-full object-cover brightness-50" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/70"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-1 bg-[#b8860b] rounded-full mr-4"></div>
                <i class="fas fa-pray text-4xl text-[#b8860b]"></i>
                <div class="w-16 h-1 bg-[#b8860b] rounded-full ml-4"></div>
            </div>
            <h1 class="text-6xl md:text-7xl font-bold mb-4 tracking-wider font-['Rowdies'] text-shadow-lg">
                ANG KAPARIAN
            </h1>
            <p class="text-xl max-w-2xl mx-auto text-white/90 mt-4">Alamin ang mga Rektor ng Dambanang Pandiyosesis ni Santa Marta</p>
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
                <span>Ang Kaparian</span>
            </div>
        </div>
    </div>

    <!-- Kaparian Content Section -->
    <div id="content" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-church text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>
                <h2 class="text-[#0d5c2f] text-4xl font-bold mb-4">MGA REKTOR NG DAMBANANG PANDIYOSESIS NI SANTA MARTA</h2>
                <p class="text-gray-700 text-lg max-w-3xl mx-auto">Ang mga sumusunod ay ang mga Rektor na naglingkod sa Dambanang Pandiyosesis ni Santa Marta mula noong ito ay itinatag noong 2009.</p>
            </div>

            <!-- First Rector -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="md:flex items-center gap-8">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <img src="{{ asset('images/Rev. Fr. Orlando B. Cantillon.JPG') }}" alt="Rev. Fr. Orlando B. Cantillon" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                            <h3 class="text-[#0d5c2f] text-3xl font-bold">Rev. Fr. Orlando B. Cantillon</h3>
                        </div>
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg mb-6 inline-block">
                            <p class="text-[#0d5c2f] font-bold">First Rector: 2009 - 2010</p>
                        </div>
                        <p class="text-gray-700 text-lg mb-4">Si Rev. Fr. Orlando B. Cantillon ang unang Rektor ng Dambanang Pandiyosesis ni Santa Marta. Sa ilalim ng kanyang pamumuno, ang ating Parokya ay iniluklok bilang Dambanang Pandiyosesis ni Santa Marta ang ating Pintakasi at Rosas ng Pateros noong taong 2009.</p>
                    </div>
                </div>
            </div>

            <!-- Second Rector -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="md:flex items-center gap-8">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <img src="{{ asset('images/Rev. Fr. Roy M. Rosales.png') }}" alt="Rev. Fr. Roy M. Rosales" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                            <h3 class="text-[#0d5c2f] text-3xl font-bold">Rev. Fr. Roy M. Rosales</h3>
                        </div>
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg mb-6 inline-block">
                            <p class="text-[#0d5c2f] font-bold">Second Rector: 2010 - 2015</p>
                        </div>
                        <p class="text-gray-700 text-lg mb-4">Si Rev. Fr. Roy M. Rosales ang ikalawang Rektor ng Dambanang Pandiyosesis ni Santa Marta. Naglingkod siya ng limang taon mula 2010 hanggang 2015, at nagpatuloy sa pagpapalakas ng debosyon kay Santa Marta sa ating komunidad.</p>
                    </div>
                </div>
            </div>

            <!-- Third Rector -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="md:flex items-center gap-8">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <img src="{{ asset('images/Rev. Fr. Jorge Jesus A. Bellosillo.JPG') }}" alt="Rev. Fr. Jorge Jesus A. Bellosillo" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                            <h3 class="text-[#0d5c2f] text-3xl font-bold">Rev. Fr. Jorge Jesus A. Bellosillo</h3>
                        </div>
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg mb-6 inline-block">
                            <p class="text-[#0d5c2f] font-bold">Third Rector: 2015 - 2021</p>
                        </div>
                        <p class="text-gray-700 text-lg mb-4">Si Rev. Fr. Jorge Jesus A. Bellosillo ang ikatlong Rektor ng Dambanang Pandiyosesis ni Santa Marta. Naglingkod siya ng anim na taon mula 2015 hanggang 2021, at nagpatuloy sa pagpapalakas ng pananampalataya at debosyon sa ating parokya.</p>
                    </div>
                </div>
            </div>

            <!-- Fourth Rector -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="md:flex items-center gap-8">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <img src="{{ asset('images/Rev. Fr. Loreto N. Sanchez, Jr..png') }}" alt="Rev. Fr. Loreto N. Sanchez, Jr." class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                    </div>
                    <div class="md:w-2/3">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                            <h3 class="text-[#0d5c2f] text-3xl font-bold">Rev. Fr. Loreto N. Sanchez, Jr.</h3>
                        </div>
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg mb-6 inline-block">
                            <p class="text-[#0d5c2f] font-bold">Fourth Rector: 2021 - present</p>
                        </div>
                        <p class="text-gray-700 text-lg mb-4">Si Rev. Fr. Loreto N. Sanchez, Jr. ang kasalukuyang Rektor ng Dambanang Pandiyosesis ni Santa Marta mula noong 2021. Sa ilalim ng kanyang pamumuno, patuloy na lumalago ang ating parokya at ang debosyon kay Santa Marta.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection