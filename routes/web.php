<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect('/tour');
});

Route::get('/admin', function () {
    return redirect('/tour');
});


Route::get('admin/login', function () {
    return view('vendor.voyager::auth.login');
})->name('voyager.login');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::group(['prefix' => 'tour'], function () {
    Route::get('/', [TourController::class, 'index'])->name('tour.index');
    Route::get('/create', [TourController::class, 'create'])->name('tour.create');
    Route::post('/', [TourController::class, 'store'])->name('tour.store');
    Route::get('/{id}/edit', [TourController::class, 'edit'])->name('tour.edit');
    Route::delete('/{id}', [TourController::class, 'destroy'])->name('tour.destroy');
    Route::post('/store', [TourController::class, 'store'])->name('tour.store');
    // Route to update a specific tour
    Route::put('/update/{id}', [TourController::class, 'update'])->name('tour.update');

    // Route to save the tour validity (1-to-many relationship)
    Route::post('/validity/save/{tourId}', [TourController::class, 'saveValidity'])->name('tour.validity.save');

    // Route to save the tour payment terms (1-to-many relationship)
    Route::post('/payment_terms/save/{tourId}', [TourController::class, 'savePaymentTerms'])->name('tour.payment_terms.save');

    // Route to save the tour inclusions (1-to-many relationship)
    Route::post('/inclusions/save/{tourId}', [TourController::class, 'saveInclusions'])->name('tour.inclusion.save');

    // Route to save the tour exclusions (1-to-many relationship)
    Route::post('/exclusions/save/{tourId}', [TourController::class, 'saveExclusions'])->name('tour.exclusion.save');

    // Route to save images (1-to-many relationship)
    Route::post('/images/save/{tourId}', [TourController::class, 'saveImages'])->name('tour.images.save');

    // Route to delete a specific tour
    Route::delete('/delete/{id}', [TourController::class, 'destroy'])->name('tour.delete');
});
