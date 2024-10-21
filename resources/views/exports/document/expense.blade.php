<table>
    <tr>
        <td class="fit">{{ $expense->expense->label }}</td>
        <td class="under"></td>

        @if ($expense->days != null)
            <td class="fit">{{ __('exports.document-expense-days') }}</td>
            <td class="under w-1"><span>{{ $format->number($expense->days) }}</span></td>
            <td class="fit">{{ __('exports.document-expense-days-suffix') }}</td>
        @endif

        <td class="fit">{{ __('exports.document-expense-total') }}</td>
        <td class="under w-2"><span>{{ $format->number($expense_total) }}</span></td>
        <td class="fit">{{ __('exports.document-expense-total-suffix') }}</td>
    </tr>
</table>
