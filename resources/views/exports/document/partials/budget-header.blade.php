<h1 class="title" style="margin: 1em 0;">{{ __('exports.document-title') }}</h1>
<section class="w-4 push-left">
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-office') }}</td>
            <td class="under"><span>{{ $office }}</span></td>
        </tr>
    </table>
    <table class="w-7 push-center">
        <tr>
            <td class="fit">{{ __('exports.document-date-day') }}</td>
            <td class="under"><span>{{ $format->date($order_at, 'd') }}</span></td>
            <td class="fit">{{ __('exports.document-date-month') }}</td>
            <td class="under"><span>{{ $format->date($order_at, 'F') }}</span></td>
            <td class="fit">{{ __('exports.document-date-year') }}</td>
            <td class="under"><span>{{ $format->date($order_at, 'Y') }}</span></td>
        </tr>
    </table>
</section>
<section class="w-4">
    <table>
        <tr>
            <td class="fit indent-mini">{{ __('exports.ducument-subject-static') }}</td>
            <td>{{ __('exports.document-subject-static-text') }}</td>
        </tr>
        <tr>
            <td class="fit">{{ __('exports.document-invitation') }}</td>
            <td class="under"><span>{{ $invitation }}</span></td>
        </tr>
    </table>
</section>
