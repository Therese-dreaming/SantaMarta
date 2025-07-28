<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/devotion', function () {
    return view('devotion');
})->name('devotion');

Route::get('/ministries', function () {
    return view('ministries');
})->name('ministries');

Route::get('/simbahan', function () {
    return view('simbahan');
})->name('simbahan');

Route::get('/diyosesis', function () {
    return view('diyosesis');
})->name('diyosesis');

Route::get('/kaparian', function () {
    return view('kaparian');
})->name('kaparian');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Email Verification Routes
Auth::routes(['verify' => true]);

// Login & Registration
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/signup', function () {
        return view('signup');
    })->name('signup');

    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
        ->name('register');
});

// Password Reset Routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');
});

// Services routes
// Add this in the public routes section
Route::get('/services', function () {
    return view('userServices');
})->name('userServices');

// Keep the existing services routes in the auth middleware group
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::post('/services/store-step1', [ServiceController::class, 'storeStep1'])->name('services.store-step1');
    Route::post('/services/store-step2', [ServiceController::class, 'storeStep2'])->name('services.store-step2');
    Route::post('/services/finalize', [ServiceController::class, 'finalizeBooking'])->name('services.finalize');
    Route::get('/services/my-bookings', [ServiceController::class, 'myBookings'])->name('services.my-bookings');

    // Payment routes
    Route::get('/services/payment/{booking}', [ServiceController::class, 'showPayment'])->name('services.payment');
    Route::post('/services/payment/{booking}', [ServiceController::class, 'storePayment'])->name('services.payment.store');
    Route::post('/services/upload-documents', [ServiceController::class, 'uploadDocuments'])->name('services.upload-documents');
    Route::get('/services/document-upload', [ServiceController::class, 'showDocumentUpload'])->name('services.document-upload');
    Route::get('/services/calendar/{serviceType}', [ServiceController::class, 'showCalendar'])->name('services.calendar');
    Route::get('/services/book', [ServiceController::class, 'create'])->name('services.book');
    Route::post('/services/book', [ServiceController::class, 'store'])->name('services.book.store');
    Route::get('/services/payment/{booking}/receipt', [ServiceController::class, 'showPaymentReceipt'])
    ->name('services.payment.receipt');

    // Service Detail Route
    // Add this with the other service routes
    Route::get('/services/booking/{booking}/details', [ServiceController::class, 'showBookingDetails'])->name('services.booking.details');
    Route::post('/bookings/{booking}/cancel', [ServiceController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{booking}/generate-certificate', [ServiceController::class, 'generateCertificate'])->name('bookings.generateCertificate');

});

// Staff and Admin routes
Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [App\Http\Controllers\Admin\DashboardController::class, 'chartData'])->name('dashboard.chart-data');

    Route::get('/bookings', [ServiceController::class, 'adminIndex'])->name('bookings');
    
    // Fix these routes - make sure they have the 'admin.' prefix in the name
    Route::post('/bookings/{booking}/approve', [ServiceController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/cancel', [ServiceController::class, 'cancel'])->name('bookings.cancel');
    
    // Change to:
    Route::put('/bookings/{booking}/verify-payment', [ServiceController::class, 'verifyPayment'])->name('bookings.verify-payment');
    Route::post('/bookings/{booking}/hold-for-payment', [ServiceController::class, 'holdForPayment'])
        ->name('bookings.hold_for_payment');
    Route::get('/bookings/{booking}/release-document', [ServiceController::class, 'releaseDocument'])
        ->name('bookings.release-document');
    // Add the missing route for generating certificates
    Route::get('/bookings/{booking}/generate-certificate', [ServiceController::class, 'generateCertificate'])
        ->name('bookings.generate-certificate');
    Route::get('/bookings/{booking}', [ServiceController::class, 'adminShowBooking'])->name('bookings.show');
    Route::post('/bookings/{booking}/update-notes', [ServiceController::class, 'updateAdminNotes'])
        ->name('bookings.update-notes');

    // Add new admin routes
    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');

    // Reports routes
    // Remove the duplicate /admin prefix
    Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/download', [App\Http\Controllers\Admin\ReportsController::class, 'download'])->name('reports.download');
    
    Route::get('/calendar', [ServiceController::class, 'calendarView'])->name('calendar');

    // Activity routes
    Route::get('/activities', 'App\Http\Controllers\ActivityController@index')->name('activities.index');
    Route::get('/activities/create', 'App\Http\Controllers\ActivityController@create')->name('activities.create');
    Route::post('/activities', 'App\Http\Controllers\ActivityController@store')->name('activities.store');
    Route::get('/activities/{activity}/edit', 'App\Http\Controllers\ActivityController@edit')->name('activities.edit');
    Route::put('/activities/{activity}', 'App\Http\Controllers\ActivityController@update')->name('activities.update');
    Route::delete('/activities/{activity}', 'App\Http\Controllers\ActivityController@destroy')->name('activities.destroy');

    // User management routes
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');

});

/*
// Priest-specific routes
Route::middleware(['auth', 'role:priest'])->prefix('priest')->group(function () {
    Route::get('/dashboard', function () {
        return view('priest.dashboard');
    })->name('priest.dashboard');
    
    Route::get('/services', [ServiceController::class, 'priestIndex'])->name('priest.services');
});
*/

// Only for development/preview - remove or protect in production
Route::get('/preview-certificate/{type}', function($type) {
    $sampleData = [
        'baptism' => [
            'booking' => new \App\Models\ServiceBooking([
                'ticket_number' => 'BAP-12345678',
                'preferred_date' => now(),
                'status' => 'approved'
            ]),
            'details' => new \App\Models\BaptismDetail([
                'child_name' => 'John Doe',
                'father_name' => 'Richard Doe',
                'mother_name' => 'Jane Doe',
                'date_of_birth' => '2024-01-01',
                'place_of_birth' => 'Sample City'
            ])
        ]
        // Add sample data for other certificate types here
    ];

    if (!isset($sampleData[$type])) {
        abort(404);
    }

    return view('certificates.' . $type, [
        'booking' => $sampleData[$type]['booking'],
        'details' => $sampleData[$type]['details'],
        'date' => now()->format('F d, Y'),
        'logo1' => public_path('images/LOGO-1.png'),
        'logo2' => public_path('images/LOGO-2.png')
    ]);
});
