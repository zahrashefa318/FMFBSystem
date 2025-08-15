<?php
namespace App\Http\Controllers;

use App\Http\Requests\ClientRegistrationRequest;
use App\Services\CustomerService;
use App\Http\Controllers\MyTableController;
use Illuminate\Http\Request;
use DomainException;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class ClientRegistrationController extends Controller
{
    protected CustomerService $customerService;
    protected MyTableController $tableController;

    public function __construct(CustomerService $customerService, MyTableController $tableController)
    {
        $this->customerService = $customerService;
        $this->tableController = $tableController;
    }

    public function store(ClientRegistrationRequest $request)
    {
        $data = $request->validated();
        if ($this->tableController->search_ssn($data['ssn'])) {
            return back()->withInput()->with('error', 'Frequent patron');
        }

        try {
            $this->customerService->registerCustomer($data);
            return redirect()->route('dashboard')->with('success', 'Data saved!');
        } catch (DomainException $e) {
            return back()->withErrors(['zipcode' => $e->getMessage()]);
        } catch (\Throwable $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred saving data');
        }
    }

    public function search_customer(Request $req)
    {
        $ssn = $req->input('ssn');
        if ($this->tableController->search_ssn($ssn)) {
            $customers = $this->customerService->searchBySsn($ssn);
            return back()->with('customerInfo', $customers);
        }
        return back()->with('message', 'No such customer found in database.');
    }

  public function updateCustomerStatus(Request $req)
    {
        $data = $req->validate([
            'repeatSsn'    => ['required', 'regex:/^\d{3}-\d{2}-\d{4}$/', 'exists:customer_tbl,social_security_num'],
            'repeatStatus' => ['required', 'string', 'in:new,paid_off'],
            'repeatDate'   => ['required', 'date', 'before_or_equal:today'],
        ], [
            'repeatSsn.required'          => 'SSN is required.',
            'repeatSsn.regex'             => 'SSN must be in the format XXX‑XX‑XXXX.',
            'repeatSsn.exists'            => 'That SSN does not exist.',
            'repeatStatus.required'       => 'Status is required.',
            'repeatStatus.in'             => 'Status must be either "new" or "paid_off".',
            'repeatDate.required'         => 'Payment date is required.',
            'repeatDate.date'             => 'Please enter a valid date.',
            'repeatDate.before_or_equal'  => 'Date cannot be in the future.',
        ], [
            'repeatSsn'    => 'SSN',
            'repeatStatus' => 'status',
            'repeatDate'   => 'payment date',
        ]);

        // Only update database when status is 'new'
        if ($data['repeatStatus'] !== 'paid_off') {
            return back()->with('info', 'No update applied unless status is "paid_off".');
        }

        $updated = Customer::where('social_security_num', $data['repeatSsn'])
            ->where('status', 'paid_off')
            ->update([
                'status'           => $data['repeatStatus'],
                'registrationdate' => $data['repeatDate'],
            ]);

        return $updated
            ? back()->with('success', 'Customer status updated to new.')
            : back()->with('info', 'No update applied — perhaps already "new".');
    }


}

?>