@extends('layouts.user')

@section('title', 'Devotion to Santa Marta')

@section('content')
<!-- Main Content -->
<main class="flex-grow">
    <!-- Hero Section with Decorative Elements -->
    <div class="relative h-[500px]">
        <img src="{{ asset('images/devotion.jpg') }}" alt="Devotion to Santa Marta" class="absolute inset-0 w-full h-full object-cover brightness-50" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/70"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-1 bg-[#b8860b] rounded-full mr-4"></div>
                <i class="fas fa-cross text-4xl text-[#b8860b]"></i>
                <div class="w-16 h-1 bg-[#b8860b] rounded-full ml-4"></div>
            </div>
            <h1 class="text-6xl md:text-7xl font-bold mb-4 tracking-wider font-['Rowdies'] text-shadow-lg">
                DEVOTION TO SANTA MARTA
            </h1>
            <p class="text-xl max-w-2xl mx-auto text-white/90 mt-4">Discover the rich history and spiritual significance of Santa Marta</p>
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
                <span>Devotion to Santa Marta</span>
            </div>
        </div>
    </div>

    <!-- Devotion Content Section -->
    <div id="content" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <!-- Introduction Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-[#0d5c2f]/10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 -mb-6 -ml-6 bg-[#b8860b]/10 rounded-full"></div>
                
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-user text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>
                
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8 relative z-10">SINO SI SANTA MARTA?</h2>
                <p class="text-gray-700 text-lg mb-6 relative z-10">Si Santa Marta ay isang mahalagang pigura sa Kristiyanismo, partikular na kilala sa kanyang pagiging masipag at mapagpatuloy. Siya ang kapatid nina Maria at Lazaro, na mga kaibigan ni Hesus. Ang kanyang kuwento ay nagbibigay-diin sa kahalagahan ng paglilingkod at pananampalataya.</p>
            </div>

            <!-- Bible Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0d5c2f] to-transparent"></div>
                
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-book-bible text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>
                
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">SI SANTA MARTA SA EBANGHELYO NI SAN LUCAS</h2>
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-[#b8860b]/20 flex items-center justify-center">
                        <i class="fas fa-quote-left text-2xl text-[#b8860b]"></i>
                    </div>
                </div>
                <h3 class="text-[#b8860b] text-2xl font-bold mb-4 text-center">Dinalaw ni Hesus sina Marta at Maria <span class="text-gray-500">(Lucas 10:38-42)</span></h3>
                <div class="max-w-3xl mx-auto">
                    <p class="text-gray-700 text-lg mb-6 italic border-l-4 border-[#b8860b] pl-6 py-2">"Inilalarawan sa tagpong ito ang pagdalaw ni Hesus sa tahanan ng magkapatid na Marta at Maria habang Siya ay naglalakbay. Sa pagtanggap nila kay Hesus bilang panauhin, naging abala si Marta sa paghahanda at pagaasikaso ng mga bagay-bagay samantalang ang kanyang kapatid na si Maria ay mas piniling maupo sa paanan ni Hesus upang makinig sa Kanyang mga salita. Lubos na nag-alala si Marta at pinakiusapan si Hesus na pagsabihan ang kanyang kapatid na tulungan siya sa kanyang mga gawain ngunit ang naging tugon ni Hesus ay ganito, "Marta, Marta, nag-aalala ka at nababagabag sa maraming bagay ngunit isang bagay lamang ang kailangan. Pinili ni Maria ang mabuting bahagi at ito'y hindi kukunin sa kanya."</p>
            </div>

            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12">
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">SI SANTA MARTA SA BAYAN NG PATEROS</h2>
                <p class="text-gray-700 text-lg mb-6">Sa makasaysayang bayan ng Pateros, masasabing maihahalintulad ang milagrong iniugnay kay Santa Marta sa bayan ng Tarascon sa bansang France. Mahigit dalawaang daan taon ang nakalipas, ang bayan ng Pateros ay binulabog ng isang malaki at mapaminsalang buwaya na kung saan kinakain nito ang mga alagang itik sa pampang ng ilog. Ang pag-aalaga ng itik ang pangungahing kabuhayan ng mga taga-Pateros noon kaya lubos na ikinabahala ito ng mga mamamayan. Isinangguni nila ang sitwasyon sa isang prayle (pari) ng lokal na simbahan upang humingi ng payo at panalangin para mapuksa ang nasabing hayop. Ipinayo ng prayle na mamintuho sila kay Santa Marta dahil sa milagrong pagpapaamo nito sa halimaw na *Tarasque (“Tarask”) sa bansang France. Sinunod ng mga mamamayan ang payong ito at namintuho sila kay Santa Marta. Kaya, isang gabi, sa ilalim ng kabilugan ng buwan, habang namemeste ang buwaya sa pampang ng ilog, milagrong may isang makisig at matapang na lalaki (na tinaguriang bayani), tangan ang itak o bolo, ang sumugod sa kinaroroonan ng buwaya at pinatay ito. Ipinagbunyi ito ng mga mamamayan ng Pateros at iniugnay ang pagpuksa sa buwaya bilang isang milagro sa tulong ng pamimintuho kay Santa Marta. Kaya’t bilang pagkilala rito, isang imahen ni Santa Marta ang ipinagawa na kung saan siya ay nakatapak sa buwaya.</p>
                <p class="text-gray-700 text-lg mb-6">Tangan ng imahen ang krus at palaspas na siyang ginamit bilang pampuksa sa nasabing hayop, na kahalintulad sa imahen ni Santa Marta na matatagpuan sa bansang France."<p>
                        <p class="text-gray-700 text-lg mb-6">Dahil sa pangyayaring ito, nagsimula at naging mayabong ang padedebosyon ng mga taga-Pateros kay Santa Marta. Magmula noon hanggang sa kasalukuyang panahon, maraming mga testimonya ng milagro at mga biyayang natamo ang iniugnay sa pamimintuho sa kanya. Kaya ang kanyang kapistahan ay dinarayo rin ng mga deboto mula sa mga karatig bayan at probinsya , at maging sa ibang bansa.</p>
            </div>

            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12">
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">ANG MGA KAPISTAHAN</h2>
                <p class="text-gray-700 text-lg mb-6">Dalawang beses ang pagdiriwang ng kapistahan ni Santa Marta sa bayan ng Pateros. Ito ay ang mga sumusunod:</p>

                <div class="grid md:grid-cols-2 gap-8 mt-8">
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-[#0d5c2f]">
                        <h3 class="text-[#0d5c2f] text-2xl font-bold mb-4">Pistang-Bayan o Pistang Pasasalamat alay kay Santa Marta</h3>
                        <p class="text-gray-700">ipinagdiriwang tuwing <span class="font-bold text-[#b8860b]">IKALAWANG LINGGO NG PEBRERO</span> (2nd Sunday of February) bilang paggunita at pasasalamat sa lahat ng mga milagro at biyayang iniugnay sa pamimintuho kay Santa Marta sa bayan ng Pateros.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-[#0d5c2f]">
                        <h3 class="text-[#0d5c2f] text-2xl font-bold mb-4">Pistang Liturhikal (Liturgical Feast)</h3>
                        <p class="text-gray-700">ipinagdiriwang tuwing <span class="font-bold text-[#b8860b]">IKA-29 NG HULYO</span> (July 29)<br>ang opisyal na kapistahan ni Santa Marta na kinikilala at ipinagdiriwang ng buong Simbahang Katolika.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12">
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">PAMPALAGIANG PANALANGIN KAY SANTA MARTA</h2>
                <p class="text-gray-700 text-lg mb-6 italic text-center">"O Diyos na makapangyarihan, dahil sa dakila Mong pagmamahal sa sangkatauhan ay nagkatawang-tao ang iyong Anak at nakipamuhay sa amin. Natagpuan niya sa iyong lingkod na si Sta. Marta ang walang pasubaling pagtanggap sa kanyang tahanan nang may masiglang paglilingkod at galak sa pakikipagkaibigan.
                    Nawa ay maging laging bukas ang aming puso sa pagtanggap sa iyong Anak na si Hesus na ang nais ay ang pakikinig sa kanyang Salitang nagbibigay buhay at tinawag na pinagpala ang lahat ng nagsasabuhay nito. Sa halimbawa ng ulirang pananalig ni Sta. Marta, ay maging buo ang loob namin na ipahayag na si Hesus ang Mesias, ang Anak ng Diyos, ang aming Buhay at Muling Pagkabuhay.
                    Pakumbabang iniluluhog namin na ibuhos mo ang Iyong masaganang pagpapala sa amin na nakaka-alaala sa malalim na pag-ibig at pananampalataya na ipinakita ni Sta. Marta sa iyong Anak. Alang-alang sa mga panalangin ni Sta. Marta ay ipagkaloob mo ang aking kahilingan (banggitin ang kahilingan) kung ito ay para sa kagalingan ko at kaluwalhatian mo. At sa wakas ng aming paglalakbay dito sa lupa, ay masapit nawa ang tahanang inihanda ni Hesus para sa amin sa langit at mamalas ang iyong kaluwalhatian kasama ng lahat ng mga banal at ng lingkod mong si Sta. Marta. Hinihiling namin ito sa ngalan ni Kristong aming Panginoon. Amen. Martang pintakasi namin, kami'y iyong idalangin. (Magdarasal ng isang Ama Namin, Aba Ginoong Maria at Luwalhati para sa intensyon ng Santo Papa.)"</p>
            </div>

            <!-- Image Gallery -->
            <div class="mt-12">
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8">GALLERY</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <img src="{{ asset('images/DEVOTION1.JPG') }}" alt="Devotion Image 1" class="w-full h-64 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ asset('images/DEVOTION2.JPG') }}" alt="Devotion Image 2" class="w-full h-64 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ asset('images/DEVOTION3.JPG') }}" alt="Devotion Image 3" class="w-full h-64 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ asset('images/DEVOTION4.JPG') }}" alt="Devotion Image 4" class="w-full h-64 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
