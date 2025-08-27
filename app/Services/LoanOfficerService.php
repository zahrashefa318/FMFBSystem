<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LoanOfficerService
{
    /**
     * Get customers for the currently authenticated officer, grouped by status.
     *
     * @return Collection<string, Collection>
     */
    public function getMyCustomersGroupedByStatus(): Collection
    {
        $username = session('username');

        return Customer::where('staff_username', $username)
            ->select('customer_id', 'first_name', 'last_name', 'status', 'registrationdate')
            ->orderBy('status')
            ->get()
            ->groupBy('status');
    }

    /**
 * Retrieve a customer by ID, including their associated address and branch address.
 *
 * Eager-loads related `address` and `branch.address` relationships to reduce database queries
 * and improve performance. Throws a ModelNotFoundException if the customer is not found,
 * which Laravel handles by returning a 404 response in HTTP context.
 *
 * @param  int  $id  The primary key of the customer to retrieve.
 * @return \App\Models\Customer  The Customer model instance with its relationships loaded.
 *
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
 */
    public function customerdetailsservice($id)
    {
    return Customer::with(['address','branch.address'])->findOrFail($id);
    }


}






?>