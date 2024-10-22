<section style="margin: 1.5em 0;">
    <table class="table">
        <thead>
            <tr>
                <th class="w-2" style="height: 2em;">{{ __('exports.certificate-table-date') }}</th>
                <th class="w-4">{{ __('exports.certificate-table-detail') }}</th>
                <th class="w-2">{{ __('exports.certificate-table-value') }}</th>
                <th class="w-2">{{ __('exports.certificate-table-note') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td class="fit" style="height: 1.5em;"></td>
                    <td class="fit">{{ $expense->expense->label }}</td>
                    <td class="fit">{{ $format->number($expense->total * ($expense->days ?? 1)) }}</td>
                    <td class="fit"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" style="height: 2em; vertical-align: middle;">
                    {{ __('exports.certificate-table-total') }}</th>
                <th class="fit" style="vertical-align: middle;">{{ $format->number($total) }}</th>
                <th class="fit"></th>
            </tr>
        </tfoot>
    </table>
</section>
