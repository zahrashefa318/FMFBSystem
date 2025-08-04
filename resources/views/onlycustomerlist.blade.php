<style>
  /* Ensure borders align and collapse */
  .table {
    border-collapse: collapse;
  }
  /* Apply solid bottom border on every row except the last */
  .table tbody tr:not(:last-child),
  .table thead tr {
    border-bottom: 1px solid #dee2e6;
  }
</style>

<div id="placeholderSection"
     class="collapse d-flex justify-content-center py-3"
     style="width:100%">
  <div class="card mb-3" style="width:100%; margin:0 auto;">
    <div class="card-header text-center">
      <h5 class="mb-0" style="text-align:center;">New Customers</h5>
    </div>
    <div class="card-body p-3">
      @if(isset($grouped) && $grouped->isNotEmpty())
        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered mb-0 mx-auto"
                 style="margin:0 auto; background-color:#341530;">
            <thead class="thead-light">
              <tr>
                <th class="text-center" style="width:120px;">ID</th>
                <th class="text-center" style="width:120px;">Name</th>
                <th class="text-center" style="width:120px;">Registered Date</th>
                <th class="text-center" style="width:120px;">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($grouped as $status => $customers)
                @foreach($customers as $cust)
                  <tr class="clickable-row align-middle"
                      data-url="{{ route('customerdetails', $cust->customer_id) }}"
                      onmouseover="this.style.cursor='pointer'; this.style.backgroundColor='lightsteelblue';"
                      onmouseout="this.style.backgroundColor='';">
                    <td class="text-center" style="width:120px; text-align:center;">
                      {{ $cust->customer_id }}
                    </td>
                    <td class="text-center" style="width:120px;text-align:center;">
                      {{ $cust->first_name }} {{ $cust->last_name }}
                    </td>
                    <td class="text-center" style="width:120px;text-align:center;">
                      {{ $cust->registrationdate }}
                    </td>
                    <td class="text-center" style="width:120px;text-align:center;">
                      {{ ucfirst($status) }}
                    </td>
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
