<style>
  .table { border-collapse: collapse; }
  .table tbody tr:not(:last-child),
  .table thead tr { border-bottom: 1px solid #dee2e6; }
  .clickable-row { cursor: pointer; }
</style>


<div id="placeholderSection" class="collapse show d-flex justify-content-center py-3" style="width:100%">
  <div class="card mb-3" style="width:100%; margin:0 auto;">
    <div class="card-header text-center">
      @php
        $statusKey=strtolower(trim((string)($status ?? '')));
        $customer_list_title=match($statusKey){
          'new'=>'New Customers',
          'pending'=>'Pending Customers',
          'approved'=>'Approved Customers',
          'denied'=>'Denied Customers',
          default =>'Customers',
        };
      @endphp
      <h5 class="mb-0" style="text-align:center;">{{$customer_list_title}}</h5>
    </div>

    <div class="card-body p-3">
      <div class="table-responsive">
        <table class="table table-dark table-striped table-hover table-bordered mb-0 mx-auto">
          <thead class="table-light">
            <tr>
              <th class="text-center" style="width:120px;text-align:center;">ID</th>
              <th class="text-center" style="width:120px;text-align:center;">Name</th>
              <th class="text-center" style="width:120px;text-align:center;">Registered Date</th>
              <th class="text-center" style="width:120px;text-align:center;">Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse (($customer ?? collect()) as $cust)
              @php
                $routeName = match (strtolower($cust->status)) {
                  'new'      => 'customerdetails',
                  'pending'  => 'customerLoanInformation',
                  'approved' => 'approvedcustomers',
                  'denied'   => 'deniedcustomers',
                  default    => 'customerdetails',
                };
              @endphp

              <tr class="clickable-row align-middle"
                  data-url="{{ route($routeName, $cust->customer_id) }}"
                   onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='lightsteelblue';"
                   onmouseout="this.style.backgroundColor='';">
                <td class="text-center" style="text-align:center;">{{ $cust->customer_id }}</td>
                <td class="text-center" style="text-align:center;">{{ $cust->first_name }} {{ $cust->last_name }}</td>
                <td class="text-center" style="text-align:center;">{{ $cust->registrationdate }}</td>
                <td class="text-center" style="text-align:center;">{{ ucfirst($cust->status) }}</td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center">No assigned customers yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

