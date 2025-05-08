@extends('layouts.user')

@section('title', 'Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Payment Details</h1>

        @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-900/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Payment Information -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Booking Information</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Service</dt>
                        <dd class="text-gray-900 dark:text-white">{{ ucfirst($booking->type) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Schedule</dt>
                        <dd class="text-gray-900 dark:text-white">
                            {{ Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }} at
                            {{ Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount Due</dt>
                        <dd class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($booking->amount, 2) }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Payment Methods -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment Methods</h2>
                <div class="space-y-4">
                    <!-- GCash -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-medium text-gray-900 dark:text-white">GCash</h3>
                            <img src="/images/gcash-logo.png" alt="GCash" class="h-8">
                        </div>
                        <div class="text-center mb-4">
                            <img src="/images/gcash-qr.png" alt="GCash QR Code" class="mx-auto w-48 h-48">
                        </div>
                        <p class="pb-2 text-m font-bold text-green-600 dark:text-gray-300 text-center">MA*******L M.</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 text-center">Scan QR code or send to: 099X-XXX-X746</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 text-center">User ID: ***********WIPNQC</p>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-medium text-gray-900 dark:text-white">Bank Transfer</h3>
                            <img src="/images/metrobank-logo.png" alt="Metrobank" class="h-8">
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600 dark:text-gray-300">Account Name: Santa Marta Parish</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Account Number: XXXX-XXXX-XXXX</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Bank: Metrobank</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Form with Enhanced Design -->
        <div class="mt-8">
            <form action="{{ route('services.payment.store', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="paymentForm">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                        <select name="payment_method" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white 
                                   focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors px-4 py-3
                                   @error('payment_method') border-red-500 @enderror">
                            <option value="">Select payment method</option>
                            <option value="gcash">GCash</option>
                            <option value="bank_transfer">Metrobank Transfer</option>
                        </select>
                        @error('payment_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reference Number</label>
                        <input type="text" name="reference_number" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white 
                                   focus:border-emerald-500 focus:ring-emerald-500 shadow-sm transition-colors px-4 py-3
                                   @error('reference_number') border-red-500 @enderror" placeholder="Enter reference number from your payment">
                        @error('reference_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Proof of Payment</label>
                    <label for="payment_proof" class="cursor-pointer block">
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg
                                    hover:border-emerald-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all
                                    @error('payment_proof') border-red-500 @enderror" id="dropZone">
                            <div class="space-y-2 text-center">
                                <div class="mx-auto h-12 w-12 text-gray-400" id="upload-icon">
                                    <i class="fas fa-cloud-upload-alt text-3xl"></i>
                                </div>
                                <div class="flex flex-col items-center text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-medium text-emerald-600 hover:text-emerald-500">Click to upload</span>
                                    <span class="mt-1">or drag and drop</span>
                                </div>
                                <input id="payment_proof" name="payment_proof" type="file" class="hidden" required accept="image/*">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, GIF up to 2MB
                                </p>
                            </div>
                        </div>
                    </label>
                    <div id="file-preview" class="mt-2 hidden">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <img id="image-preview" class="h-16 w-16 object-cover rounded" src="" alt="Preview">
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="text-sm font-medium text-gray-900 dark:text-white" id="file-name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400" id="file-size"></div>
                            </div>
                            <button type="button" id="remove-file" class="ml-4 text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div id="upload-error" class="mt-2 hidden text-sm text-red-600"></div>
                    @error('payment_proof')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#0d5c2f] text-white rounded-lg 
                                               hover:bg-[#0d5c2f]/90 transition-colors shadow-sm" id="submitBtn">
                        <i class="fas fa-check mr-2"></i>
                        Submit Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this script at the end of the file -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const fileInput = document.getElementById('payment_proof');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const imagePreview = document.getElementById('image-preview');
    const removeFile = document.getElementById('remove-file');
    const uploadIcon = document.getElementById('upload-icon');
    const dropZone = document.getElementById('dropZone');
    const uploadError = document.getElementById('upload-error');
    const submitBtn = document.getElementById('submitBtn');

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showError(message) {
        uploadError.textContent = message;
        uploadError.classList.remove('hidden');
        dropZone.classList.add('border-red-500');
    }

    function clearError() {
        uploadError.textContent = '';
        uploadError.classList.add('hidden');
        dropZone.classList.remove('border-red-500');
    }

    function validateFile(file) {
        clearError();

        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            showError('Please upload an image file (PNG, JPG, or GIF)');
            return false;
        }

        // Check file size (2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (file.size > maxSize) {
            showError('File size must be less than 2MB');
            return false;
        }

        return true;
    }

    function handleFile(file) {
        if (!file) return;

        if (!validateFile(file)) {
            fileInput.value = '';
            return;
        }

        // Show preview
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        // Create image preview
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        filePreview.classList.remove('hidden');
        uploadIcon.innerHTML = '<i class="fas fa-check text-emerald-500 text-3xl"></i>';
    }

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        handleFile(file);
    });

    removeFile.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
        fileName.textContent = '';
        fileSize.textContent = '';
        imagePreview.src = '';
        uploadIcon.innerHTML = '<i class="fas fa-cloud-upload-alt text-3xl"></i>';
        clearError();
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        if (!fileInput.files || !fileInput.files[0]) {
            e.preventDefault();
            showError('Please select a proof of payment image');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-900/10');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-900/10');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        fileInput.files = dt.files;
        handleFile(file);
    }
});
</script>
@endpush
@endsection
