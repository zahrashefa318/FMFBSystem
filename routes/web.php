<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MyTableController;
use App\Http\Controllers\MyAuthController;
use App\Http\Controllers\ClientRegistrationController; 
use App\Http\Controllers\LoanOfficerController;
use App\Http\Controllers\LoanApplicationFormController;


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
    return view('welcome');
})->name('welcome');

Route::post('/login',[MyAuthController::class,'login'])->name('login');
Route::get('/dashboard', [MyAuthController::class,'dashboard'])->name('dashboard');

Route::post('/to_customertbl', [ClientRegistrationController::class, 'store'])->name('to_customertbl');
Route::post('/search_ssn', [ClientRegistrationController::class, 'search_customer'])->name('search_ssn');
Route::post('/update_customer',[ClientRegistrationController::class,'updateCustomerStatus'])->name('update_customer');
Route::get('/onlycustomerlist/{status}', [LoanOfficerController::class, 'LoanOfficerdashboard'])
     ->name('onlycustomerlist')->middleware('staff.auth');
Route::get('/customerdetails/{id}',[LoanOfficerController::class, 'customerdetails'])->name('customerdetails');
Route::get('/loanApplicationForm', [LoanApplicationFormController::class, 'viewLoanApplicationForm'])
     ->name('loanApplicationForm');   
Route::post('/submitForm',[LoanApplicationFormController::class,'submitForm'])->name('submitForm');  
Route::get('/customerLoanInformation/{id}',[LoanOfficerController::class, 'customerLoanInformation'])->name('customerLoanInformation');

Route::post('/approvedCustomer/{customerId}',[LoanOfficerController::class, 'approvedCustomer'])->name('approvedCustomer');




?>