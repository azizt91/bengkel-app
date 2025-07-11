<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return redirect('/login');
// });

Route::get('/dashboard', \App\Http\Controllers\DashboardRedirectController::class)
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class);
    Route::resource('spare-parts', App\Http\Controllers\Admin\SparePartController::class)->parameters(['spare-parts' => 'sparePart']);
    Route::post('/bookings/{booking}/set-amount', [App\Http\Controllers\Admin\BookingController::class,'setAmountAndComplete'])->name('bookings.setAmount');
        Route::post('/bookings/{booking}/details', [App\Http\Controllers\Admin\BookingController::class,'saveDetails'])->name('bookings.details');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/assign', [\App\Http\Controllers\Admin\BookingController::class, 'assignTechnician'])->name('bookings.assign-technician');
    Route::get('/bookings/export', [\App\Http\Controllers\Admin\BookingController::class, 'export'])->name('bookings.export');

    // Payments
    Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/export', [\App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('payments.export');
    Route::put('/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('payments.update');

    // Technicians
    Route::get('/technicians', [\App\Http\Controllers\Admin\TechnicianController::class, 'index'])->name('technicians.index');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Users (hanya di admin)
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Filament Routes
    Route::middleware(['auth', 'filament'])->prefix('filament')->group(function () {
        Route::get('/admin/resources/technicians', [\App\Http\Controllers\Admin\TechnicianController::class, 'index'])->name('filament.admin.resources.technicians.index');
        Route::get('/admin/resources/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('filament.admin.resources.payments.index');
        Route::get('/admin/resources/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('filament.admin.resources.bookings.index');
        Route::get('/admin/resources/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('filament.admin.resources.users.index');
    });


});

// Technician
Route::middleware(['auth','role:teknisi'])->prefix('technician')->name('technician.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Technician\DashboardController::class, 'index'])->name('dashboard');

    Route::get('bookings', [\App\Http\Controllers\Technician\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [\App\Http\Controllers\Technician\BookingController::class, 'show'])->name('bookings.show');
    Route::put('bookings/{booking}', [\App\Http\Controllers\Technician\BookingController::class, 'update'])->name('bookings.update');
    Route::post('bookings/{booking}/progress', [\App\Http\Controllers\Technician\ProgressController::class, 'store'])->name('bookings.progress.store');
    Route::post('bookings/{booking}/claim', [\App\Http\Controllers\Technician\BookingController::class, 'claim'])->name('bookings.claim');

    // Reviews
    Route::get('reviews', [\App\Http\Controllers\Technician\ReviewController::class, 'index'])->name('reviews.index');
});

Route::middleware(['auth','role:pelanggan'])->prefix('customer')->name('customer.')->group(function () {
    // dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');

    // vehicles CRUD
    Route::resource('vehicles', \App\Http\Controllers\Customer\VehicleController::class);
    Route::post('vehicles/{vehicle}/regenerate-qr', [\App\Http\Controllers\Customer\VehicleController::class, 'regenerateQr'])->name('vehicles.regenerate-qr');

    // bookings
    Route::get('bookings', [\App\Http\Controllers\Customer\BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [\App\Http\Controllers\Customer\BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [\App\Http\Controllers\Customer\BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [\App\Http\Controllers\Customer\BookingController::class, 'show'])->name('bookings.show');
    Route::get('bookings/{booking}/invoice', [\App\Http\Controllers\Customer\InvoiceController::class, 'download'])->name('bookings.invoice.download');

    // payments
    Route::get('bookings/{booking}/payment', [\App\Http\Controllers\Customer\PaymentController::class, 'create'])->name('bookings.payment.create');
    Route::post('bookings/{booking}/payment', [\App\Http\Controllers\Customer\PaymentController::class, 'store'])->name('bookings.payment.store');

    // reviews
    Route::get('bookings/{booking}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('bookings.review.create');
    Route::post('bookings/{booking}/review', [\App\Http\Controllers\Customer\ReviewController::class, 'store'])->name('bookings.review.store');
});

// Alias route for Filament Technician resource list
Route::get('/admin/filament-technicians', [App\Http\Controllers\Admin\TechnicianController::class, 'index'])
    ->middleware(['auth','role:admin'])
    ->name('filament.admin.resources.technicians.index');

// Public vehicle tracking by QR token
Route::middleware('throttle:60,1')->get('/track/{token}', \App\Http\Controllers\VehicleTrackController::class)->name('vehicle.track');

require __DIR__.'/auth.php';
