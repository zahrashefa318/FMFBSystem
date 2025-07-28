<?php
 namespace App\Services;

use App\Models\Customer;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function registerCustomer(array $data): Customer
    {
        $zipcode = (int) $data['zipcode'];
        $config = config('filterByzip');
        [$branchId, $loanOfficer] = $this->determineBranchAndStaff($zipcode, $config);

        if (!$branchId) {
            throw new \DomainException('No branch found for that ZIP code.');
        }

        return DB::transaction(function () use ($data, $branchId, $loanOfficer) {
            $address = Address::create([
                'street' => $data['addrStreet'],
                'city'   => $data['addrCity'],
                'state'  => $data['addrState'],
                'zipcode'=> $data['zipcode'],
            ]);

            return Customer::create([
                'first_name'           => $data['firstName'],
                'last_name'            => $data['lastName'],
                'social_security_num'  => $data['ssn'],
                'phone'                => $data['phone'],
                'email'                => $data['email'],
                'type_of_business'     => $data['businessType'],
                'time_in_business'     => $data['timeInBusiness'],
                'business_phone'       => $data['businessPhone'],
                'registrationdate'     => $data['registrationDate'],
                'status'               => 'new',
                'branch_id'            => $branchId,
                'staff_username'       => $loanOfficer,
                'address_id'           => $address->address_id,
            ]);
        });
    }

    protected function determineBranchAndStaff(int $zipcode, array $config): array
    {
        foreach ($config['branches'] as $id => [$min, $max]) {
            if ($zipcode >= (int)$min && $zipcode <= (int)$max) {
                $userArray = $config['loanOfficerPerBranch'][$id] ?? [];
                $count = count($userArray);
                $index = $count > 0 ? $zipcode % $count : null;
                $loanOfficer = $count > 0 ? ($userArray[$index] ?? null) : null;

                Log::debug('Branch lookup', [
                    'branch_id'   => $id,
                    'zipcode'     => $zipcode,
                    'user_array'  => $userArray,
                    'user_count'  => $count,
                    'index'       => $index,
                    'loanOfficer' => $loanOfficer,
                ]);

                return [$id, $loanOfficer];
            }
        }
        return [null, null];
    }

    public function searchBySsn(string $ssn)
    {
        return Customer::where('social_security_num', $ssn)
            ->select('first_name', 'last_name', 'registrationdate', 'status')
            ->first();
    }
}


?>