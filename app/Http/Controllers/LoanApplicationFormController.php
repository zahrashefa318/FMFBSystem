<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class LoanApplicationFormController extends Controller
{
    public function viewLoanApplicationForm()
    {
        return view('loanApplicationForm');
    }
}
?>