<section>
    <table>
        <tr>
            <td class="fit indent">
                {{ __('exports.document-expense-header') }}

                [{!!$companions->count() <= 0 ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>': ' '!!}] {{__('exports.document-expense-header-user')}}
                [{!!$companions->count() > 0 ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>': ' '!!}] {{__('exports.document-expense-header-companion')}}

                ดังนี้
            </td>
        </tr>
    </table>
    @foreach ($expenses as $expense)
        @php
            $expense_total = $expense->total * ($expense->days ?? 1);
            $total += $expense_total;
        @endphp
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
    @endforeach
    <table>
        <tr>
            <td class="grow"></td>
            <td class="fit">{{ __('exports.document-expenses-total') }}</td>
            <td class="under w-2"><span>{{ $format->number($total) }}</span></td>
            <td class="fit">{{ __('exports.document-expense-total-suffix') }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-expense-total-text') }}</td>
            <td class="under w-2"><span>{{ $format->bahtText($total) }}</span></td>
        </tr>
    </table>
</section>
