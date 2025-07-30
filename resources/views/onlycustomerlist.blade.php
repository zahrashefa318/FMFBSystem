<div id="placeholderSection" class="collapse d-flex justify-content-center py-3" style="width:100%">
  <div class="card mb-3" style="width: 100%; margin: 0 auto;">
    <div class="card-header text-center">
      <h5 class="mb-0"style="text-align:center">New Customers</h5>
    </div>
    <div class="card-body p-3">
      @if(isset($grouped) && $grouped->isNotEmpty())
        <div class="table-responsive"style="background-color:green" >
          <table class="table table-striped table-hover table-bordered mb-0 mx-auto" style="margin: 0 auto; background-color:red; ">
            <thead class="thead-light">
              <tr>
                <th style="width:120px;" class="text-center">ID</th>
                <th style="width:120px;"class="text-center">Name</th>
                <th style="width:120px;"class="text-center">Registered Date</th>
                <th style="width:120px;"class="text-center">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($grouped as $status => $customers)
                @foreach($customers as $cust)
                  <tr class="align-middle clickable-row" style="cursor: pointer;"
                      onclick="window.location='{{ route('customer.show', $cust->customer_id) }}'">                    <th style="width:120px;"scope="row" class="px-5 text-center">{{ $cust->customer_id }}</th>
                    <td style="width:120px;text-align:center;">{{ $cust->first_name }} {{ $cust->last_name }}</td>
                    <td style="width:120px;text-align:center;">{{ $cust->registrationdate }}</td>
                    <td style="width:120px;text-align:center;">{{ ucfirst($status) }}</td>
                  </tr>
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center">No assigned customers yet.</div>
      @endif
    </div>
  </div>
</div>
