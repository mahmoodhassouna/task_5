<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AddCashController;
use App\Http\Controllers\WithdrawCashController;
use App\Http\Controllers\DisplayWalletController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InstallmentController;
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
    return view('wallets.addCash');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function (){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('create/wallet',[WalletController::class,'create'])->name('createWallet');
    Route::get('/',[WalletController::class,'index'])->name('main');
    Route::get('wallets',[WalletController::class,'wallets'])->name('wallets');
    Route::post('create/wallet',[WalletController::class,'store'])->name('storeWallet');
    Route::post('close/wallet',[WalletController::class,'closeWallet'])->name('closeWallet');

//    Route::get('cash/',[AddCashController::class,'index'])->name('createCash');
    Route::get('create/cash/{id}',[AddCashController::class,'create'])->name('createCash');
    Route::post('store/cash',[AddCashController::class,'store'])->name('storeCash');


    Route::get('create/withdraw/{id}',[WithdrawCashController::class,'create'])->name('createWithdraw');
    Route::post('store/withdraw',[WithdrawCashController::class,'store'])->name('storeWithdraw');
    Route::post('store/withdrawWithClose',[WithdrawCashController::class,'storeWithdrawWithClose'])->name('storeWithdrawWithClose');


    Route::get('display/wallet/{id}',[DisplayWalletController::class,'index'])->name('displayWallet');


    Route::get('orders',[OrderController::class,'index'])->name('orders');
    Route::get('ordersTable',[OrderController::class,'orders'])->name('ordersTable');
    Route::get('create/order',[OrderController::class,'create'])->name('createOrder');
    Route::get('accept/order/{id}',[OrderController::class,'acceptOrder'])->name('acceptOrder');
    Route::post('create/store',[OrderController::class,'store'])->name('storeOrder');
    Route::post('rejected/order',[OrderController::class,'rejectedOrder'])->name('rejectedOrder');
    Route::post('payment/order',[OrderController::class,'paymentOrder'])->name('paymentOrder');
    Route::delete('delete/order/{id}',[OrderController::class,'destroy']);

    Route::get('installments/order/{id}',[InstallmentController::class,'installments'])->name('installmentsOrder');
    Route::get('installments/data/{id}',[InstallmentController::class,'installmentsData'])->name('installmentsData');
    Route::get('installments',[InstallmentController::class,'index'])->name('installments');
    Route::get('installmentSchedulingView',[InstallmentController::class,'installmentSchedulingView'])->name('installmentSchedulingView');
    Route::get('installmentScheduling',[InstallmentController::class,'installmentScheduling'])->name('installmentScheduling');
    Route::get('installmentsDue',[InstallmentController::class,'installmentsDue'])->name('installmentsDue');
    Route::post('installment/data/edit',[InstallmentController::class,'edit'])->name('installmentDataEdit');

    Route::post('installment/search',[InstallmentController::class,'search'])->name('installmentSearch');
    Route::get('insPyments',[InstallmentController::class,'insPyments'])->name('insPyments');
    Route::get('installmentsPayment',[InstallmentController::class,'installmentsPayment'])->name('installmentsPayment');
    Route::post('installment/payment',[InstallmentController::class,'Payment'])->name('installmentPayment');


    Route::get('importExcel',[InstallmentController::class,'importExcel'])->name('importExcel');
    Route::post('installment/importExcel',[InstallmentController::class,'import'])->name('installmentImportExcel');


});
