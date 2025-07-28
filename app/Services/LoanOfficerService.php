<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LoanOfficerDashboardService
{
    /**
     * Get customers for the currently authenticated officer, grouped by status.
     *
     * @return Collection<string, Collection>
     */
    public function getMyCustomersGroupedByStatus(): Collection
    {
        $username = Auth::user()->username;

        return Customer::where('staff_username', $username)
            ->select('customer_id', 'first_name', 'last_name', 'status', 'registrationdate')
            ->orderBy('status')
            ->get()
            ->groupBy('status');
    }
}






?>