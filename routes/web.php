<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MyTableController;  // Correct namespace and path


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
});

Route::post('/login',function(Illuminate\Http\Request $req){
    $user_id = $req->input('user_id');
    $password=$req->input('password');

    $staff=DB::table('stafftbl')->where ('username',$user_id)
                                ->where('password',$password)
                                ->first();

    if ($staff){
        session(['username'=>$user_id]);
        return redirect()->route('dashboard');
    }
    return redirect()->route('welcome')->with('error','Invalid Credentials!');
})->name('login');

Route::get('/dashboard', function() {
    $username = session('username');
    if ($username === 'receptionist12plk') {
    return view('customerForm');
}
return view('loanOfficerDashboard');
})->name('dashboard');

Route::post('/to_customertbl', [MyTableController::class, 'save'])->name('to_customertbl');
Route::post('/search_ssn', [MyTableController::class, 'search_ssn'])->name('search_ssn');

?>