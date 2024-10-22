<section>
    @foreach ($addresses as $address)
        <table>
            <tr>
                <td class="fit">{{ $address->from->label }} {{ __('exports.document-address-from-label') }}
                </td>
                <td class="under"><span>{{ $format->date($address->from_date, 'd') }}</span></td>
                <td class="fit">{{ __('exports.document-date-month') }}</td>
                <td class="under"><span>{{ $format->date($address->from_date, 'F') }}</span></td>
                <td class="fit">{{ __('exports.document-date-year') }}</td>
                <td class="under"><span>{{ $format->date($address->from_date, 'Y') }}</span></td>
                <td class="fit">{{ __('exports.document-address-back-label') }} {{ $address->back->label }}
                </td>
                <td class="under"><span>{{ $format->date($address->back_date, 'd') }}</span></td>
                <td class="fit">{{ __('exports.document-date-month') }}</td>
                <td class="under"><span>{{ $format->date($address->back_date, 'F') }}</span></td>
                <td class="fit">{{ __('exports.document-date-year') }}</td>
                <td class="under"><span>{{ $format->date($address->back_date, 'Y') }}</span></td>
            </tr>
        </table>
    @endforeach
    <table class="w-6">
        <tr>
            <td class="fit">{{ __('exports.document-days-total') }}</td>
            <td class="under"><span>{{ $format->number($days) }}</span></td>
            <td class="fit">{{ __('exports.document-days-day') }}</td>
            <td class="under"><span>{{ $format->number($hours - $days * 24) }}</span></td>
            <td class="fit">{{ __('exports.document-days-hour') }}</td>
        </tr>
    </table>
</section>
