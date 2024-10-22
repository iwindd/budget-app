<section>
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-serial') }}</td>
            <td class="under"><span>{{ $serial }}</span></td>
            <td class="fit">{{ __('exports.document-date') }}</td>
            <td class="under"><span>{{ $format->date($date) }}</span></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-name') }}</td>
            <td class="under w-4"><span>{{ $owner }}</span></td>
            <td class="fit">{{ __('exports.document-value') }}</td>
            <td class="under"><span>{{ $format->number($value) }}</span></td>
            <td class="fit">{{ __('exports.document-value-suffix') }}</td>
            <td class="fit text-right w-1">{{ __('exports.document-format') }}</td>
        </tr>
    </table>
</section>
