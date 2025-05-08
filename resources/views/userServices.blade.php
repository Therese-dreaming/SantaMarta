@extends('layouts.user')

@section('title', 'Services')

@section('content')
<main class="flex-grow">
    <!-- Hero Section -->
    <div class="relative h-[40vh] -mt-[80px]">
        <img src="{{ asset('images/church-bg.jpg') }}" alt="Church Background" class="absolute inset-0 w-full h-full object-cover brightness-50" />
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Our Services</h1>
            <p class="text-xl">Serving the community through faith and devotion</p>
        </div>
    </div>

    <!-- Services Section -->
    <div class="bg-white py-20">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Baptism -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-water text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Baptism</h3>
                    <p class="text-gray-600 mb-4">Welcome your child into the Christian faith through the sacred sacrament of Baptism.</p>
                    @auth
                        <a href="{{ route('services.book') }}?type=baptism" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                            Book Now <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                            Login to Book <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>

                <!-- Wedding -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-rings-wedding text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Wedding</h3>
                    <p class="text-gray-600 mb-4">Celebrate your love and commitment through the sacred bond of marriage.</p>
                    @auth
                        <a href="{{ route('services.book') }}?type=wedding" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                            Book Now <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                            Login to Book <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endauth
                </div>

                <!-- Mass Intention -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-church text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Mass Intention</h3>
                    <p class="text-gray-600 mb-4">Request a Mass to be celebrated for your special intentions or loved ones.</p>
                    <a href="{{ route('services.book') }}?type=mass_intention" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Blessing -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-pray text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">House/Car Blessing</h3>
                    <p class="text-gray-600 mb-4">Receive blessings for your home, vehicle, or other possessions.</p>
                    <a href="{{ route('services.book') }}?type=blessing" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Confirmation -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-dove text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Confirmation</h3>
                    <p class="text-gray-600 mb-4">Complete your Christian initiation through the sacrament of Confirmation.</p>
                    <a href="{{ route('services.book') }}?type=confirmation" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Sick Call -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-hospital-user text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Sick Call</h3>
                    <p class="text-gray-600 mb-4">Request pastoral care and anointing for the sick and elderly.</p>
                    <a href="{{ route('services.book') }}?type=sick_call" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection