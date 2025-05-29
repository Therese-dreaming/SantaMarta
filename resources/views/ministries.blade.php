@extends('layouts.user')

@section('title', 'Parish Ministries')

@section('content')
<!-- Main Content -->
<main class="flex-grow">
    <!-- Hero Section with Decorative Elements -->
    <div class="relative h-[500px]">
        <img src="{{ asset('images/ministries.jpg') }}" alt="Parish Ministries" class="absolute inset-0 w-full h-full object-cover brightness-50" />
        <div class="absolute inset-0 bg-gradient-to-b from-black/30 to-black/70"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4">
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-1 bg-[#b8860b] rounded-full mr-4"></div>
                <i class="fas fa-hands-helping text-4xl text-[#b8860b]"></i>
                <div class="w-16 h-1 bg-[#b8860b] rounded-full ml-4"></div>
            </div>
            <h1 class="text-6xl md:text-7xl font-bold mb-4 tracking-wider font-['Rowdies'] text-shadow-lg">
                PARISH MINISTRIES
            </h1>
            <p class="text-xl max-w-2xl mx-auto text-white/90 mt-4">Serving the community through faith, dedication, and love</p>
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
                <span>Parish Ministries</span>
            </div>
        </div>
    </div>

    <!-- Ministries Content Section -->
    <div id="content" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <!-- Introduction Section -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-32 h-32 -mt-8 -mr-8 bg-[#0d5c2f]/10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 -mb-6 -ml-6 bg-[#b8860b]/10 rounded-full"></div>
                
                <div class="flex items-center justify-center mb-8">
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                    <i class="fas fa-church text-3xl text-[#0d5c2f]"></i>
                    <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                </div>
                
                <h2 class="text-[#0d5c2f] text-4xl font-bold text-center mb-8 relative z-10">OUR PARISH MINISTRIES</h2>
                <p class="text-gray-700 text-lg mb-6 relative z-10">Our parish is blessed with various ministries that serve the community in different ways. Each ministry plays a vital role in nurturing faith, fostering community spirit, and extending the love of Christ to all. We invite you to learn more about our ministries and consider joining one that resonates with your calling.</p>
            </div>

            <!-- Ministry of Devotion & Piety -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0d5c2f] to-transparent"></div>
                
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-[#0d5c2f]/10 flex items-center justify-center mr-6">
                        <i class="fas fa-pray text-4xl text-[#0d5c2f]"></i>
                    </div>
                    <h3 class="text-[#0d5c2f] text-3xl font-bold">Ministry on Devotion & Piety</h3>
                </div>
                
                <div class="pl-24">
                    <p class="text-gray-700 text-lg mb-6">This ministry focuses on nurturing and promoting the devotional life within the parish, particularly emphasizing the veneration of Santa Marta and San Roque. It plays a significant role during feast days and other religious events.</p>
                    
                    <div class="bg-[#0d5c2f]/5 p-4 rounded-lg mb-6">
                        <h4 class="text-[#0d5c2f] font-bold mb-2">Key Responsibilities:</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Organizing novenas and prayer services</li>
                            <li>Maintaining devotional areas within the church</li>
                            <li>Coordinating feast day celebrations</li>
                            <li>Promoting traditional Catholic devotions</li>
                        </ul>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center text-[#0d5c2f] hover:text-[#b8860b] transition-colors">
                            <span class="mr-2">Join this ministry</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Social Communications Ministry -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0d5c2f] to-transparent"></div>
                
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-[#0d5c2f]/10 flex items-center justify-center mr-6">
                        <i class="fas fa-video text-4xl text-[#0d5c2f]"></i>
                    </div>
                    <h3 class="text-[#0d5c2f] text-3xl font-bold">📹 Social Communications Ministry (SocCom)</h3>
                </div>
                
                <div class="pl-24">
                    <p class="text-gray-700 text-lg mb-6">The Social Communications Ministry is responsible for managing the parish's online presence, including its official website and social media platforms. They handle the dissemination of information, live streaming of Masses, and other digital communications.</p>
                    
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg">
                            <h4 class="text-[#0d5c2f] font-bold mb-2">Digital Platforms:</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center"><i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook Page</li>
                                <li class="flex items-center"><i class="fab fa-youtube text-red-600 mr-2"></i> YouTube Channel</li>
                                <li class="flex items-center"><i class="fas fa-globe text-[#0d5c2f] mr-2"></i> Parish Website</li>
                                <li class="flex items-center"><i class="fab fa-instagram text-purple-600 mr-2"></i> Instagram</li>
                            </ul>
                        </div>
                        
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg">
                            <h4 class="text-[#0d5c2f] font-bold mb-2">Services:</h4>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Live streaming of Masses and events</li>
                                <li>Parish announcements and updates</li>
                                <li>Digital archiving of parish activities</li>
                                <li>Graphic design for parish materials</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center text-[#0d5c2f] hover:text-[#b8860b] transition-colors">
                            <span class="mr-2">Join this ministry</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Vocation Ministry -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0d5c2f] to-transparent"></div>
                
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-[#0d5c2f]/10 flex items-center justify-center mr-6">
                        <i class="fas fa-hands text-4xl text-[#0d5c2f]"></i>
                    </div>
                    <h3 class="text-[#0d5c2f] text-3xl font-bold">Vocation Ministry</h3>
                </div>
                
                <div class="pl-24">
                    <p class="text-gray-700 text-lg mb-6">The Vocation Ministry aims to foster an environment that encourages individuals to consider and pursue religious vocations. They work closely with families, schools, and other parish ministries to support this mission.</p>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-[#0d5c2f] mb-6">
                        <blockquote class="text-gray-700 italic">
                            "The harvest is plentiful, but the laborers are few; therefore ask the Lord of the harvest to send out laborers into his harvest." <span class="font-bold">- Matthew 9:37-38</span>
                        </blockquote>
                    </div>
                    
                    <div class="bg-[#0d5c2f]/5 p-4 rounded-lg mb-6">
                        <h4 class="text-[#0d5c2f] font-bold mb-2">Activities:</h4>
                        <ul class="list-disc pl-5 space-y-2">
                            <li>Vocation awareness programs</li>
                            <li>Prayer services for vocations</li>
                            <li>Mentoring and guidance for those discerning a vocation</li>
                            <li>Collaboration with diocesan vocation office</li>
                        </ul>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center text-[#0d5c2f] hover:text-[#b8860b] transition-colors">
                            <span class="mr-2">Join this ministry</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Singles for Christ -->
            <div class="bg-gray-50 rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#0d5c2f] to-transparent"></div>
                
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-[#0d5c2f]/10 flex items-center justify-center mr-6">
                        <i class="fas fa-users text-4xl text-[#0d5c2f]"></i>
                    </div>
                    <h3 class="text-[#0d5c2f] text-3xl font-bold">Singles for Christ (SFC) – San Roque-Pateros Chapter</h3>
                </div>
                
                <div class="pl-24">
                    <p class="text-gray-700 text-lg mb-6">SFC is a community for single men and women aged 21 to 40. The San Roque-Pateros chapter actively participates in parish activities, focusing on spiritual growth, service, and fellowship among its members.</p>
                    
                    <div class="grid md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg text-center">
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-cross text-[#0d5c2f] text-2xl"></i>
                            </div>
                            <h4 class="text-[#0d5c2f] font-bold mb-2">Faith Formation</h4>
                            <p>Regular prayer meetings, retreats, and spiritual formation programs</p>
                        </div>
                        
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg text-center">
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-hands-helping text-[#0d5c2f] text-2xl"></i>
                            </div>
                            <h4 class="text-[#0d5c2f] font-bold mb-2">Community Service</h4>
                            <p>Outreach programs, mission work, and parish service activities</p>
                        </div>
                        
                        <div class="bg-[#0d5c2f]/5 p-4 rounded-lg text-center">
                            <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-heart text-[#0d5c2f] text-2xl"></i>
                            </div>
                            <h4 class="text-[#0d5c2f] font-bold mb-2">Fellowship</h4>
                            <p>Social gatherings, sports events, and community building activities</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="#" class="inline-flex items-center text-[#0d5c2f] hover:text-[#b8860b] transition-colors">
                            <span class="mr-2">Join this ministry</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Join a Ministry Section -->
            <div class="bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCI+CjxyZWN0IHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgZmlsbD0id2hpdGUiPjwvcmVjdD4KPHBhdGggZD0iTTAgMzBDMTUgMTUgMTUgNDUgMzAgMzBTNDUgMTUgNjAgMzBDNDUgNDUgNDUgMTUgMzAgMzBTMTUgNDUgMCAxNSIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMGQ1YzJmIiBzdHJva2Utd2lkdGg9IjEiIG9wYWNpdHk9IjAuMSI+PC9wYXRoPgo8L3N2Zz4=')] rounded-xl shadow-lg p-8 mb-12 relative overflow-hidden">
                <div class="absolute inset-0 bg-white/90"></div>
                
                <div class="relative z-10 text-center">
                    <div class="flex items-center justify-center mb-8">
                        <div class="w-12 h-1 bg-[#0d5c2f] rounded-full mr-4"></div>
                        <i class="fas fa-hand-holding-heart text-3xl text-[#0d5c2f]"></i>
                        <div class="w-12 h-1 bg-[#0d5c2f] rounded-full ml-4"></div>
                    </div>
                    
                    <h2 class="text-[#0d5c2f] text-4xl font-bold mb-6">JOIN A MINISTRY TODAY</h2>
                    <p class="text-gray-700 text-lg mb-8 max-w-3xl mx-auto">Our parish ministries welcome new members who wish to serve God and the community. If you feel called to join any of these ministries, please fill out the form below or contact the parish office.</p>
                    
                    <a href="#" class="inline-block bg-[#0d5c2f] text-white px-8 py-3 rounded-lg hover:bg-[#0d5c2f]/80 transition-colors text-lg font-bold">
                        <i class="fas fa-envelope mr-2"></i> Contact Us to Join
                    </a>
                </div>
            </div>
            
            <!-- Back to Top Button -->
            <div class="fixed bottom-8 right-8 z-40">
                <a href="#" class="w-12 h-12 bg-[#0d5c2f] text-white rounded-full flex items-center justify-center shadow-lg hover:bg-[#b8860b] transition-colors duration-300">
                    <i class="fas fa-chevron-up"></i>
                </a>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
@endsection