<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MyTableController;
use App\Http\Controllers\MyAuthController;
use App\Http\Controllers\ClientRegistrationController; 
use App\Http\Controllers\LoanOfficerController;
use App\Http\Controllers\LoanApplicationFormController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

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

/*Route::get('/', function () {
    return view('welcome');
})->name('welcome');*/
Route::view('/', 'welcome')->name('welcome');  // shows your Blade


// Show the login view (welcome) only at /login, for guests
Route::view('/login', 'welcome')->middleware('guest')->name('login');



Route::post('/login',[MyAuthController::class,'login'])->name('login.post');
Route::post('/logout',[MyAuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
Route::get('/dashboard', [MyAuthController::class,'dashboard'])->name('dashboard');

Route::post('/to_customertbl', [ClientRegistrationController::class, 'store'])->name('to_customertbl');
Route::post('/search_ssn', [ClientRegistrationController::class, 'search_customer'])->name('search_ssn');
Route::post('/update_customer',[ClientRegistrationController::class,'updateCustomerStatus'])->name('update_customer');
Route::get('/onlycustomerlist/{status}', [LoanOfficerController::class, 'LoanOfficerdashboard'])
     ->name('onlycustomerlist');
Route::get('/customerdetails/{id}',[LoanOfficerController::class, 'customerdetails'])->name('customerdetails');
Route::get('/loanApplicationForm', [LoanApplicationFormController::class, 'viewLoanApplicationForm'])
     ->name('loanApplicationForm');   
Route::post('/submitForm',[LoanApplicationFormController::class,'submitForm'])->name('submitForm');  
Route::get('/customerLoanInformation/{id}',[LoanOfficerController::class, 'customerLoanInformation'])->name('customerLoanInformation');

Route::match(['get','post'],'/approvedCustomer/{customerId}',[LoanOfficerController::class, 'approvedCustomer'])->name('approvedCustomer');


Route::post('/emailSchedule/{loan:loan_id}',[LoanOfficerController::class, 'emailSchedule'])->name('emailSchedule');
Route::get('/email-sent', function () {
    return view('emailSent');  // simple view for status
})->name('emailSent');


Route::get('/test-email', function () {
    Mail::to('zahra.shefa.1990@gmail.com')->send(new TestEmail());
    return 'Email sent (or failed — check logs)!';
});

Route::delete('/customerdestroy/{id}',[LoanOfficerController::class, 'customerdestroy'])->name('customerdestroy');
// route for search customer in loan officer dashboard: 
Route::match(['get','post'],'/search_customer_for_loanofficer',[LoanOfficerController::class, 'search_customer_for_loanofficer'])
            ->name('search_customer_for_loanofficer');

Route::post('/deny/{id}',[LoanOfficerController::class, 'deny'])->name('deny');

Route::get('/DeniedApprovedDetail/{id}', [LoanOfficerController::class, 'DeniedApprovedDetail'])->name('DeniedApprovedDetail');
Route::patch('/customers/{customer}', [LoanOfficerController::class, 'edit'])
     ->name('customers.update');
});
?>