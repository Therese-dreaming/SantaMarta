@extends('layouts.user')

@section('title', 'Ang Diyosesis ng Pasig')

@section('content')
<!-- Main Content -->
<main class="flex-grow">
    <!-- Hero Section with Decorative Elements -->
    <div class="relative h-[500px]">
        <img src="{{ asset('images/devotion.jpg') }}" alt="Diyosesis ng Pasig" class="absolute inset-0 w-full h-full object-cover brightness-50" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/70"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-1 bg-[#b8860b] rounded-full mr-4"></div>
                <i class="fas fa-cross text-4xl text-[#b8860b]"></i>
                <div class="w-16 h-1 bg-[#b8860b] rounded-full ml-4"></div>
            </div>
            <h1 class="text-6xl md:text-7xl font-bold mb-4 tracking-wider font-['Rowdies'] text-shadow-lg">
                ANG DIYOSESIS NG PASIG
            </h1>
            <p class="text-xl max-w-2xl mx-auto text-white/90 mt-4">Alamin ang kasaysayan at kahalagahan ng Diyosesis ng Pasig</p>
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
                <span>Ang Diyosesis ng Pasig</span>
            </div>
        </div>
    </div>

    <!-- Diyosesis Content Section -->
    <div id="content" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <!-- Historical Background Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-[#0d5c2f]/10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 -mb-6 -ml-6 bg-[#b8860b]/10 rounded-full"></div>
                
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-book-open text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>

                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">HISTORICAL BACKGROUND</h2>

                <div class="max-w-3xl mx-auto">
                    <p class="text-gray-700 text-lg mb-6">The Diocese of Pasig has a rich historical background rooted in the Catholic faith and tradition.</p>
                </div>
            </div>

            <!-- The Seal Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-certificate text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>

                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">THE SEAL</h2>

                <div class="md:flex items-center gap-8 my-8">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <img src="{{ asset('images/THE SEAL.png') }}" alt="Seal of the Diocese of Pasig" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                        <p class="text-sm text-center mt-2 text-gray-500 italic">Ang Escudo ng Diyosesis ng Pasig</p>
                    </div>
                    <div class="md:w-1/2">
                        <p class="text-gray-700 text-lg mb-4">Ang Escudo ng Diyosesis ng Pasig ay sumasagisag sa paanyaya ng Inang Simbahang Katolika sa lahat, kasama ng mga pangunahing patron sa sina Santa Ana, San Roque, Santa Marta at ng Birheng Maria, na sama-samang maglakbay sa ilog ng buhay patungo sa Panginoong Diyos.</p>
                        <p class="text-gray-700 text-lg mb-4">Ang kabuuan ng escudo ay nahahati sa dalawang bahagi ng tatlong pares na maalong guhit na kulay puti at bughaw na sumasagisag sa ilog na nag-uugny sa tatlong baying sakop ng Diyosesis ng Pasig. Sa ilog ding ito nagsimula ang sibilisasyon, kultura, hanapbuhay at pananampalataya ng mga naunang mamamayan, at patuloy na sumasagisag sa pagbabago ng panahon, ng kalikasanb at ng mga tao. Sinasagisag naman ng mala-langit na bughaw ang kalangitan at ang luntiang bahagi naman ay sumasagisag sa ugat ng diyosesis bilang isang masaganang kabukiran na dinidilig ng ilog Pasig.</p>
                        <p class="text-gray-700 text-lg mb-4">Sa may gawing itaas ay matatagpuan ang titik na A at M na pinaliligiran ng labing dalawang bituing ginto at napapaibabaw sa ginintuang buwan na sumasagisag sa Birheng Maria, ang pangunahing patron ng Pasig sa titulong Our Lady of Immaculate Conception.</p>
                        <p class="text-gray-700 text-lg mb-4">Samantala, ang Taguig, ay kinakatawan ng kanyang pangunahing patrona na si Santa Ana na sinasagisag ng aklat na nakabukas. Madalas na inilalarawan si Santa Ana na nagtuturo sa kanyang anak, ang Mahal na Birhen, at higit na mahalaga sa kanyang itinuro ay ang tungkol sa tipan ng Diyos. Ang aklat na nakabukas at may dalawang tali na sumasagisag naman sa letrang Griego, Alpha, ang unang letra ng alpabeto na katumbasng Hebreong Aleph na sagisag ng Diyos bilang ugat at simula ng lahat. Ang uhay ng palay naman ay sagisag ng bunga ng pawis ng mga taga-giik na pinaniniliwalang pinanggalingan ng pangalan ng bayan ng Taguig.</p>
                    </div>
                </div>
            </div>

            <!-- The Bishop of Pasig Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-user-tie text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>

                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">THE BISHOP OF PASIG</h2>

                <div class="md:flex items-center gap-8 my-8">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <img src="{{ asset('images/BISHOP.JPG') }}" alt="Bishop of Pasig" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                        <p class="text-sm text-center mt-2 text-gray-500 italic">Most Rev. Mylo Hubert Claudio Vergara</p>
                    </div>
                    <div class="md:w-1/2">
                        <div class="bg-[#0d5c2f]/5 p-6 rounded-xl mb-6">
                            <h4 class="text-[#0d5c2f] font-bold mb-2">Most Rev. Mylo Hubert Claudio Vergara</h4>
                            <ul class="space-y-2">
                                <li><span class="font-semibold">Born:</span> October 23, 1962</li>
                                <li><span class="font-semibold">Ordained Priest:</span> March 24, 1990</li>
                                <li><span class="font-semibold">Ordained Bishop:</span> April 30, 2005</li>
                                <li><span class="font-semibold">Appointed as Bishop of Pasig:</span> April 20, 2011</li>
                                <li><span class="font-semibold">Installed as Bishop of Pasig:</span> June 23, 2011</li>
                            </ul>
                        </div>
                        <p class="text-gray-700 text-lg mb-4">The Holy Father, Pope Benedict XVI has appointed Most Rev. Mylo Hubert Claudio Vergara, previously the Bishop of San Jose, Nueva Ecija as the new Bishop of Pasig.</p>
                        <p class="text-gray-700 text-lg mb-4">Bishop Mylo Hubert Claudio Vergara was born in Manila last October 23, 1962. He finished his studies at the Ateneo de Manila High School, B.S. Management Engineering and Masters in Philosophy at the Ateneo de Manila University. He finished his Licentiate in Sacred Theology at the Loyola School of Theology and Doctorate in Sacred Theology at the University of Santo Tomas. After his ordination to the priesthood last March 24, 1990 for the Archdiocese of Manila at the end of 1994, he became Dean of Studies and Professor of Philosophy of the Holy Apostles Senior Seminary, EDSA, Guadalupe, Makati City. He also served as parochial vicar of the Parish of St. Andrew the Apostle.</p>
                    </div>
                </div>
            </div>

            <!-- The Coat of Arms Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-shield-alt text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>

                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">THE COAT OF ARMS</h2>

                <div class="md:flex items-center gap-8 my-8">
                    <div class="md:w-1/2 mb-6 md:mb-0">
                        <img src="{{ asset('images/COAT OF ARMS.png') }}" alt="Coat of Arms" class="w-full h-auto rounded-lg shadow-lg transform transition-all duration-500 hover:scale-[1.02] hover:shadow-xl" />
                        <p class="text-sm text-center mt-2 text-gray-500 italic">The Coat of Arms of the Bishop of Pasig</p>
                    </div>
                    <div class="md:w-1/2">
                        <p class="text-gray-700 text-lg mb-4"><strong>"Pasce agnos meos"</strong>, literally translated as "Feed my lambs" (Jn. 21, 17) – this is our Bishop's motto which expressed his faith like that of Peter who was called by Jesus to translate his love for him into action. Bishop Mylo Hubert Claudio Vergara officially takes over as the second Bishop of Pasig with the Canonical Installation on June 23, 2011, 3 p.m. at the Immaculate Conception Cathedral, Malinao, Pasig.</p>
                        <p class="text-gray-700 text-lg mb-4">The symbol on the left side of the shield represents the Diocese of Pasig. On the right side are his personal symbols: the 12 stars symbolizing the Holy Apostles and the Seminary where he received seminary formation, the symbol of Mary as the Immaculate Conception, Patroness of both Archdiocese of Manila and Diocese of Cubao, the meek lamb symbolizing the offering his life as a sacrifice for the people he is called to minister. It is also symbolical of Jesus, the Good Shepherd and the parish in Novaliches where his vocation flourished.</p>
                        <p class="text-gray-700 text-lg mb-4">The three symbols on the lower crest represent the saints who molded his vocation – <strong> Ignatius of Loyola, John of the Cross, Teresa of Avila, Therese of the Child Jesus,</strong> and <strong> Thomas Aquinas</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection