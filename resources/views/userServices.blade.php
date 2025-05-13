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
                    <a href="#" onclick="showServiceInfo('baptism')" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
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
                    <a href="#" onclick="showServiceInfo('wedding')" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
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
                    @auth
                    <a href="#" onclick="showServiceInfo('mass_intention')" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Login to Book <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endauth
                </div>

                <!-- Blessing -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-pray text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">House/Car Blessing</h3>
                    <p class="text-gray-600 mb-4">Receive blessings for your home, vehicle, or other possessions.</p>
                    @auth
                    <a href="#" onclick="showServiceInfo('blessing')" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Login to Book <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endauth
                </div>

                <!-- Confirmation -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-dove text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Confirmation</h3>
                    <p class="text-gray-600 mb-4">Complete your Christian initiation through the sacrament of Confirmation.</p>
                    @auth
                    <a href="#" onclick="showServiceInfo('confirmation')" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Login to Book <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endauth
                </div>

                <!-- Sick Call -->
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 mb-4 flex items-center justify-center text-[#0d5c2f] bg-[#0d5c2f]/10 rounded-xl">
                        <i class="fas fa-hospital-user text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Sick Call</h3>
                    <p class="text-gray-600 mb-4">Request pastoral care and anointing for the sick and elderly.</p>
                    @auth
                    <a href="#" onclick="showServiceInfo('sick_call')" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Book Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-flex items-center text-[#0d5c2f] font-semibold hover:text-[#b8860b] transition-colors">
                        Login to Book <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</main>


<!-- Add this at the bottom of the page -->
<div id="serviceInfoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg w-full max-w-3xl mx-auto flex flex-col max-h-[90vh]">
        <div class="flex justify-between items-center p-6 sticky top-0 bg-[#0d5c2f] border-b z-10">
            <h3 class="text-xl font-semibold text-white" id="modalTitle">Service Information</h3>
            <button onclick="closeServiceInfo()" class="text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <div id="serviceContent">
                @include('services.partials.baptism-info')
                @include('services.partials.wedding-info')
                @include('services.partials.mass-intention-info')
                @include('services.partials.blessing-info')
                @include('services.partials.confirmation-info')
                @include('services.partials.sick-call-info')
            </div>
        </div>
        <div class="sticky bottom-0 bg-[#0d5c2f] border-t p-6">
            <div class="flex items-start gap-3">
                <input type="checkbox" id="understandCheckbox" class="mt-1.5 h-5 w-5 rounded border-gray-300 text-[#18421F] focus:ring-[#18421F]">
                <div class="flex-grow">
                    <label for="understandCheckbox" class="text-sm font-medium text-white block">I understand and agree to provide all the required documents and follow the scheduling guidelines.</label>
                    <div id="checkboxError" class="hidden text-red-300 text-sm mt-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Please acknowledge that you understand the requirements before proceeding.</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="handleUnderstand()" class="bg-white text-[#0d5c2f] px-6 py-2 rounded-lg hover:bg-gray-100 font-semibold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    I Understand
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedService = '';

    function showServiceInfo(serviceType) {
        selectedService = serviceType;
        const modal = document.getElementById('serviceInfoModal');
        const title = document.getElementById('modalTitle');

        // Hide all service info divs first
        document.querySelectorAll('.service-info').forEach(div => {
            div.classList.add('hidden');
        });

        // Show the selected service info
        const serviceInfo = document.getElementById(serviceType + 'Info');
        if (serviceInfo) {
            serviceInfo.classList.remove('hidden');
            title.textContent = serviceType.charAt(0).toUpperCase() + serviceType.slice(1).replace('_', ' ') + ' Service Information';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeServiceInfo() {
        const modal = document.getElementById('serviceInfoModal');
        const content = document.getElementById('serviceContent');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function proceedToBooking() {
        window.location.href = `{{ route('services.book') }}?service_type=${selectedService}&understood=1`;
    }

    function handleUnderstand() {
        const checkbox = document.getElementById('understandCheckbox');
        const checkboxError = document.getElementById('checkboxError');

        if (checkbox.checked) {
            checkboxError.classList.add('hidden');
            // Redirect to booking page with service type and understood parameters
            window.location.href = `{{ route('services.book') }}?service_type=${selectedService}&understood=1`;
        } else {
            checkboxError.classList.remove('hidden');
        }
    }

</script>
@endsection
