<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('index');
})->name('index');


// Route::get('/auth', function () {
//   return redirect('/auth');
// });

// Route::get('/phpinfo', function () {
//   phpinfo();
// });

Route::get('/rekap/{student}/pdf', [\App\Http\Controllers\RekapPdfController::class, 'export'])
  ->name('rekap.pdf');
