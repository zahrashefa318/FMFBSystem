<style>
  .table { border-collapse: collapse; }
  .table tbody tr:not(:last-child),
  .table thead tr { border-bottom: 1px solid #dee2e6; }
  .clickable-row { cursor: pointer; }

  /* Context menu styling for right click event hundler of delete option*/
  .ctxmenu {
    position: fixed;
    min-width: 180px;
    background: #1f2937; /* dark gray */
    color: #fff;
    border: 1px solid #374151;
    border-radius: 8px;
    box-shadow: 0 10px 18px rgba(0,0,0,.25);
    display: none;
    z-index: 2000;
  }
  .ctxmenu .item {
    padding: .6rem .9rem;
    cursor: pointer;
    user-select: none;
    white-space: nowrap;
  }
  .ctxmenu .item:hover { background: #374151; }
  .ctxmenu .item.danger:hover { background: #7f1d1d; } /* red-ish */
</style>


                              <!--        Right click menu       -->
<!-- CSRF for fetch() -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Context menu -->
<div id="rowContextMenu" class="ctxmenu" role="menu" aria-hidden="true">
  <div class="item danger" id="ctxDelete">Delete…</div>
</div>

                                <!--          Table of contents             -->
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

<!--        Script for right click event hundler and showing the delete option      -->
  <script>
(() => {
  const tbody = document.querySelector('table.table tbody');
  const menu = document.getElementById('rowContextMenu');
  const delBtn  = document.getElementById('ctxDelete');
  const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  let currentRow = null;    // <tr>
  let currentId  = null;    // customer_id

  // Show custom context menu
  tbody?.addEventListener('contextmenu', (e) => {
    const row = e.target.closest('tr.clickable-row');
    if (!row) return;
    e.preventDefault();

    currentRow = row;
    currentId  = row.querySelector('td:first-child')?.textContent?.trim();

    // Position menu at mouse coords
    const { clientX:x, clientY:y } = e;
    menu.style.left = x + 'px';
    menu.style.top  = y + 'px';
    menu.style.display = 'block';
    menu.setAttribute('aria-hidden', 'false');
  });

  // Hide menu on click elsewhere / ESC / scroll
  function hideMenu() {
    menu.style.display = 'none';
    menu.setAttribute('aria-hidden', 'true');
  }
  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target)) hideMenu();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') hideMenu();
  });
  document.addEventListener('scroll', hideMenu, true);

  // "Delete"
  delBtn.addEventListener('click', async () => {
    hideMenu();
    if (!currentId) return;

    if (!confirm(`Delete customer #${currentId} and all related records? This cannot be undone.`)) {
      return;
    }

    try {
      // Call your Laravel route
      const resp = await fetch(`{{ route('customerdestroy', ':id') }}`.replace(':id', currentId), {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrf,
          'Accept': 'application/json'
        }
      });

      if (!resp.ok) {
        const t = await resp.text();
        throw new Error(t || `HTTP ${resp.status}`);
      }

      // Remove row from the table
      currentRow.remove();
      alert(`Customer #${currentId} deleted.`);
    } catch (err) {
      console.error(err);
      alert('Delete failed. See console for details.');
    }
  });
})();
</script>

