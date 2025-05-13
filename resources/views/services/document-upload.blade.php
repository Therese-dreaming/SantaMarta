@extends('layouts.user')

@section('title', 'Upload Documents')

@section('content')
<div class="bg-white min-h-screen py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Step Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-[#0d5c2f] text-white flex items-center justify-center">1</div>
                        <div class="ml-2 text-[#0d5c2f] font-medium">Details</div>
                    </div>
                    <div class="w-16 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-[#0d5c2f] text-white flex items-center justify-center">2</div>
                        <div class="ml-2 text-gray-600 font-medium">Calendar</div>
                    </div>
                    <div class="w-16 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-[#0d5c2f] text-white flex items-center justify-center">3</div>
                        <div class="ml-2 text-gray-600 font-medium">Documents</div>
                    </div>
                </div>
            </div>

            <h1 class="text-4xl font-bold text-[#0d5c2f] mb-8">Required Documents</h1>

            <div class="bg-white rounded-3xl p-8 shadow-xl">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Please upload all required documents before proceeding. Accepted formats: PDF, JPG, JPEG, PNG.
                                <br>Maximum file size: 5MB per document.
                            </p>
                        </div>
                    </div>
                </div>

                <form id="documentUploadForm" action="{{ route('services.upload-documents') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="service_type" id="uploadServiceType" value="{{ $service_type }}">

                    <div class="mb-6 bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Upload Progress</h3>
                        <div class="space-y-2" id="uploadProgress">
                            @if($service_type === 'baptism')
                            <div class="flex items-center justify-between text-sm">
                                <span>Birth Certificate (Certified True Copy)</span>
                                <span id="birth_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div id="marriage_certificate_progress" class="flex items-center justify-between text-sm hidden">
                                <span>Parents' Marriage Contract</span>
                                <span id="marriage_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div id="baptismal_permit_progress" class="flex items-center justify-between text-sm hidden">
                                <span>Baptismal Permit</span>
                                <span id="baptismal_permit_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            @endif
                            @if($service_type === 'wedding')
                            <div class="flex items-center justify-between text-sm">
                                <span>Baptismal Certificate</span>
                                <span id="baptismal_cert_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Confirmation Certificate</span>
                                <span id="confirmation_cert_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>CENOMAR</span>
                                <span id="cenomar_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Marriage License</span>
                                <span id="marriage_license_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            @endif
                            @if($service_type === 'confirmation')
                            <div class="flex items-center justify-between text-sm">
                                <span>Baptismal Certificate</span>
                                <span id="baptismal_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>First Communion Certificate</span>
                                <span id="communion_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Certificate of Attendance</span>
                                <span id="attendance_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Birth Certificate</span>
                                <span id="birth_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span>Sponsor's Confirmation Certificate</span>
                                <span id="sponsor_certificate_status" class="text-gray-500">Not uploaded</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Baptism Documents -->
                    @if($service_type === 'baptism')
                    <div id="baptismDocs" class="document-section space-y-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Baptism Documents</h2>

                        <!-- Additional Questions -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Additional Information</h3>

                            <!-- Marriage Status Question -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 mb-2">Are the parents married?</p>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="parents_married" id="parents_married_yes" value="yes" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                        <label for="parents_married_yes" class="ml-2 block text-sm text-gray-700">Yes</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="parents_married" id="parents_married_no" value="no" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300" checked>
                                        <label for="parents_married_no" class="ml-2 block text-sm text-gray-700">No</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Parish Question -->
                            <div>
                                <p class="text-sm text-gray-700 mb-2">Is the child from another parish?</p>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="other_parish" id="other_parish_yes" value="yes" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                        <label for="other_parish_yes" class="ml-2 block text-sm text-gray-700">Yes</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="other_parish" id="other_parish_no" value="no" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300" checked>
                                        <label for="other_parish_no" class="ml-2 block text-sm text-gray-700">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Birth Certificate Input -->
                        <div class="upload-field space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Birth Certificate (Certified True Copy) <span class="text-red-500">*</span></label>
                            <label for="birth_certificate" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="birth_certificate" name="birth_certificate" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="birth_certificate_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Please bring the original copy for verification</p>
                        </div>

                        <!-- Marriage Contract Input (Conditional) -->
                        <div id="marriage_certificate_section" class="upload-field space-y-2 hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parents' Marriage Contract <span class="text-red-500">*</span></label>
                            <label for="marriage_certificate" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="marriage_certificate" name="marriage_certificate" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="marriage_certificate_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Baptismal Permit Input (Conditional) -->
                        <div id="baptismal_permit_section" class="upload-field space-y-2 hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Baptismal Permit <span class="text-red-500">*</span></label>
                            <label for="baptismal_permit" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="baptismal_permit" name="baptismal_permit" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="baptismal_permit_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Wedding Documents -->
                    @if($service_type === 'wedding')
                    <div id="weddingDocs" class="document-section space-y-4">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Wedding Requirements</h2>
                        <!-- Baptismal Certificate Input -->
                        <div class="upload-field space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Baptismal Certificate <span class="text-red-500">*</span></label>
                            <label for="baptismal_cert" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="baptismal_cert" name="baptismal_cert" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="baptismal_cert_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Must be newly issued with notation for "Marriage Purposes"</p>
                        </div>

                        <!-- Confirmation Certificate Input -->
                        <div class="upload-field space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Confirmation Certificate <span class="text-red-500">*</span></label>
                            <label for="confirmation_cert" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="confirmation_cert" name="confirmation_cert" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="confirmation_cert_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Must be newly issued with notation for "Marriage Purposes"</p>
                        </div>

                        <!-- CENOMAR Input -->
                        <div class="upload-field space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">CENOMAR <span class="text-red-500">*</span></label>
                            <label for="cenomar" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="cenomar" name="cenomar" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="cenomar_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Certificate of No Marriage from PSA</p>
                        </div>

                        <!-- Marriage License Input -->
                        <div class="upload-field space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marriage License <span class="text-red-500">*</span></label>
                            <label for="marriage_license" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="marriage_license" name="marriage_license" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="marriage_license_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Marriage Status Questions -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Additional Information</h3>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" name="marriage_status" id="neither" value="neither" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300" checked>
                                    <label for="neither" class="ml-2 block text-sm text-gray-700">Neither living together nor civilly married</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="radio" name="marriage_status" id="living_together" value="living_together" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                    <label for="living_together" class="ml-2 block text-sm text-gray-700">Living together for 5 years or more</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="radio" name="marriage_status" id="civilly_married" value="civilly_married" class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                    <label for="civilly_married" class="ml-2 block text-sm text-gray-700">Civilly married</label>
                                </div>
                            </div>
                        </div>

                        <!-- Affidavit of Cohabitation (Conditional) -->
                        <div id="cohabitation_docs" class="upload-field space-y-2 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center justify-between">
                                <span>Affidavit of Cohabitation <span class="text-gray-400">(If applicable)</span></span>
                                <span class="text-xs text-gray-500">Max: 5MB</span>
                            </label>
                            <label for="affidavit_cohabitation" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <!-- Same upload zone structure as other fields -->
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="affidavit_cohabitation" name="affidavit_cohabitation" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="affidavit_cohabitation_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Required for couples living together for 5 years or more</p>
                        </div>

                        <!-- Civil Marriage Contract (Conditional) -->
                        <div id="civil_marriage_docs" class="upload-field space-y-2 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center justify-between">
                                <span>Civil Marriage Contract <span class="text-gray-400">(If applicable)</span></span>
                                <span class="text-xs text-gray-500">Max: 5MB</span>
                            </label>
                            <label for="civil_marriage_contract" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="civil_marriage_contract" name="civil_marriage_contract" type="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PDF, JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="civil_marriage_contract_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Required only if civilly married (must include Registered Number)</p>
                        </div>

                        <!-- ID Pictures -->
                        <div class="upload-field space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">2x2 ID Pictures <span class="text-red-500">*</span></label>
                            <label for="id_pictures" class="cursor-pointer block">
                                <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                    <div class="space-y-2 text-center">
                                        <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                        </div>
                                        <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                            <span class="mt-1">or drag and drop</span>
                                        </div>
                                        <input id="id_pictures" name="id_pictures" type="file" class="hidden" required accept=".jpg,.jpeg,.png">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            JPG, PNG up to 5MB
                                        </p>
                                    </div>
                                </div>
                            </label>
                            <div id="id_pictures_preview" class="hidden">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                                    </div>
                                    <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">1 piece each (2x2 size)</p>
                        </div>
                    </div>
            </div>
            @endif

            <!-- Confirmation Documents -->
            @if(request('service') === 'confirmation')
            <div id="confirmationDocs" class="document-section space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Confirmation Requirements</h2>
                <div class="upload-field space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Baptismal Certificate <span class="text-red-500">*</span></label>
                    <label for="baptismal_certificate" class="cursor-pointer block">
                        <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                    <span class="mt-1">or drag and drop</span>
                                </div>
                                <input id="baptismal_certificate" name="baptismal_certificate" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF, JPG, PNG up to 5MB
                                </p>
                            </div>
                        </div>
                    </label>
                    <div id="baptismal_certificate_preview" class="hidden">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                            </div>
                            <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Original or certified true copy</p>
                </div>
                <!-- First Communion Certificate Input -->
                <div class="upload-field space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Communion Certificate <span class="text-red-500">*</span></label>
                    <label for="communion_certificate" class="cursor-pointer block">
                        <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                    <span class="mt-1">or drag and drop</span>
                                </div>
                                <input id="communion_certificate" name="communion_certificate" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF, JPG, PNG up to 5MB
                                </p>
                            </div>
                        </div>
                    </label>
                    <div id="communion_certificate_preview" class="hidden">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                            </div>
                            <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Certificate of Attendance Input -->
                <div class="upload-field space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Certificate of Attendance in Confirmation Classes <span class="text-red-500">*</span></label>
                    <label for="attendance_certificate" class="cursor-pointer block">
                        <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                    <span class="mt-1">or drag and drop</span>
                                </div>
                                <input id="attendance_certificate" name="attendance_certificate" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF, JPG, PNG up to 5MB
                                </p>
                            </div>
                        </div>
                    </label>
                    <div id="attendance_certificate_preview" class="hidden">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                            </div>
                            <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Birth Certificate Input -->
                <div class="upload-field space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Birth Certificate <span class="text-red-500">*</span></label>
                    <label for="birth_certificate" class="cursor-pointer block">
                        <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                    <span class="mt-1">or drag and drop</span>
                                </div>
                                <input id="birth_certificate" name="birth_certificate" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF, JPG, PNG up to 5MB
                                </p>
                            </div>
                        </div>
                    </label>
                    <div id="birth_certificate_preview" class="hidden">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                            </div>
                            <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sponsor's Confirmation Certificate Input -->
                <div class="upload-field space-y-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sponsor's Confirmation Certificate <span class="text-red-500">*</span></label>
                    <label for="sponsor_certificate" class="cursor-pointer block">
                        <div class="upload-zone mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400 upload-icon">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                    <span class="mt-1">or drag and drop</span>
                                </div>
                                <input id="sponsor_certificate" name="sponsor_certificate" type="file" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF, JPG, PNG up to 5MB
                                </p>
                            </div>
                        </div>
                    </label>
                    <div id="sponsor_certificate_preview" class="hidden">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-2xl text-emerald-500"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white file-name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 file-size"></div>
                            </div>
                            <button type="button" class="remove-file ml-4 text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
                    <!-- Add before the form -->
                    <div class="mb-4">
                        <a href="{{ route('services.calendar', ['serviceType' => session('booking_step1.service_type')]) }}" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Calendar
                        </a>
                    </div>
                    <button type="submit" class="bg-[#0d5c2f] text-white px-6 py-2 rounded-lg hover:bg-[#0d5c2f]/90 transition duration-150 ease-in-out flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        Upload Documents
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all file inputs
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            initializeFileUpload(input.id, input.id + '_preview');
        });

        const marriageStatusRadios = document.querySelectorAll('input[name="marriage_status"]');
        const cohabitationDocs = document.getElementById('cohabitation_docs');
        const civilMarriageDocs = document.getElementById('civil_marriage_docs');

        function updateDocumentFields() {
            const selectedStatus = document.querySelector('input[name="marriage_status"]:checked').value;

            // Hide both document sections initially
            cohabitationDocs.classList.add('hidden');
            civilMarriageDocs.classList.add('hidden');

            // Show relevant section based on selection
            if (selectedStatus === 'living_together') {
                cohabitationDocs.classList.remove('hidden');
                document.getElementById('affidavit_cohabitation').required = true;
                document.getElementById('civil_marriage_contract').required = false;
            } else if (selectedStatus === 'civilly_married') {
                civilMarriageDocs.classList.remove('hidden');
                document.getElementById('civil_marriage_contract').required = true;
                document.getElementById('affidavit_cohabitation').required = false;
            } else {
                document.getElementById('affidavit_cohabitation').required = false;
                document.getElementById('civil_marriage_contract').required = false;
            }
        }

        // Add event listeners to radio buttons
        marriageStatusRadios.forEach(radio => {
            radio.addEventListener('change', updateDocumentFields);
        });

        // Initialize the form state
        updateDocumentFields();
    });

    function initializeFileUpload(inputId, previewId) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const dropZone = input.closest('.upload-zone');
        const preview = document.getElementById(previewId);
        const statusElement = document.getElementById(inputId + '_status');
        const fileName = preview && preview.querySelector('.file-name');
        const fileSize = preview && preview.querySelector('.file-size');
        const removeBtn = preview && preview.querySelector('.remove-file');
        const uploadIcon = dropZone && dropZone.querySelector('.upload-icon');

        function updateStatus(file) {
            if (statusElement) {
                if (file) {
                    statusElement.textContent = '✓ Uploaded';
                    statusElement.className = 'text-emerald-500 font-medium';
                } else {
                    statusElement.textContent = 'Not uploaded';
                    statusElement.className = 'text-gray-500';
                }
            }
        }

        function handleFile(file) {
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.classList.remove('hidden');
                        if (fileName) fileName.textContent = file.name;
                        if (fileSize) fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                    }
                    if (dropZone) {
                        dropZone.classList.add('border-emerald-500', 'bg-gray-50');
                        if (uploadIcon) uploadIcon.innerHTML = '<i class="fas fa-check text-emerald-500"></i>';
                    }
                    updateStatus(file);
                };
                reader.readAsDataURL(file);
            }
        }

        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            handleFile(file);
        });

        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                input.value = '';
                if (preview) preview.classList.add('hidden');
                if (dropZone) {
                    dropZone.classList.remove('border-emerald-500', 'bg-gray-50');
                    if (uploadIcon) uploadIcon.innerHTML = '<i class="fas fa-cloud-upload-alt text-3xl"></i>';
                }
                updateStatus(null);
            });
        }

        if (dropZone) {
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-emerald-500');
            });

            dropZone.addEventListener('dragleave', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-emerald-500');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                const file = e.dataTransfer.files[0];
                input.files = e.dataTransfer.files;
                handleFile(file);
            });
        }
    }

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Marriage status handling
        const marriageRadios = document.querySelectorAll('input[name="parents_married"]');
        const marriageCertSection = document.getElementById('marriage_certificate_section');
        const marriageCertProgress = document.getElementById('marriage_certificate_progress');

        function updateMarriageCertVisibility() {
            const isMarried = document.querySelector('input[name="parents_married"]:checked').value === 'yes';
            marriageCertSection.classList.toggle('hidden', !isMarried);
            marriageCertProgress.classList.toggle('hidden', !isMarried);
            document.getElementById('marriage_certificate').required = isMarried;
        }

        marriageRadios.forEach(radio => {
            radio.addEventListener('change', updateMarriageCertVisibility);
        });

        // Parish handling
        const parishRadios = document.querySelectorAll('input[name="other_parish"]');
        const baptismalPermitSection = document.getElementById('baptismal_permit_section');
        const baptismalPermitProgress = document.getElementById('baptismal_permit_progress');

        function updateBaptismalPermitVisibility() {
            const isOtherParish = document.querySelector('input[name="other_parish"]:checked').value === 'yes';
            baptismalPermitSection.classList.toggle('hidden', !isOtherParish);
            baptismalPermitProgress.classList.toggle('hidden', !isOtherParish);
            document.getElementById('baptismal_permit').required = isOtherParish;
        }

        parishRadios.forEach(radio => {
            radio.addEventListener('change', updateBaptismalPermitVisibility);
        });

        // Initialize visibility
        updateMarriageCertVisibility();
        updateBaptismalPermitVisibility();
    });

</script>
