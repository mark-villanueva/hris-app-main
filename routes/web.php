<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayslipController;


Route::get('/payslip/{record}/download', [PayslipController::class, 'downloadPdf'])->name('payslip.download');

Route::get('/', function () {
    return view('welcome');
});

