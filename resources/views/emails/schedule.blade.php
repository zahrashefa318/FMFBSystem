<x-mail::message>
# Loan Repayment Schedule

**Principal:** ${{ number_format($loan->total_loan_given, 2) }}  
**APR:** {{ number_format($loan->interest_rate, 2) }}%  
**Term:** {{ $loan->duration }} months  
**Monthly Payment:** ${{ number_format($monthlyPayment, 2) }}

<x-mail::panel>
Start: {{ \Carbon\Carbon::parse($loan->start_date)->toDateString() }} &nbsp;·&nbsp;
End: {{ \Carbon\Carbon::parse($loan->end_date)->toDateString() }}
</x-mail::panel>


{{-- IMPORTANT: don’t indent Markdown tables inside <x-mail::table> (Markdown parsers treat indented lines as code). --}}
<x-mail::table>
| # | Date | Payment | Interest | Principal | Balance |
|:-:|:-----|--------:|---------:|----------:|--------:|
@foreach($schedule as $row)
| {{ $row['payment_no'] }} | {{ \Carbon\Carbon::parse($row['date'])->toDateString() }} | ${{ number_format($row['payment'], 2) }} | ${{ number_format($row['interest'], 2) }} | ${{ number_format($row['principal'], 2) }} | {{ $row['balance'] == 0 ? '—' : '$'.number_format($row['balance'], 2) }} |
@endforeach
</x-mail::table>



<x-mail::button :url="route('loans.show', $loan->loan_id)" color="primary">
View Schedule in Portal
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
