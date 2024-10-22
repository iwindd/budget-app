<section>
    <table>
        <tr>
            <td class="fit indent">{{ __('exports.certificate-total-text') }}</td>
            <td class="under" colspan="3"><span>{{ $format->bahtText($total) }}</span></td>
        </tr>
        <tr>
            <td class="fit text-right">{{ __('exports.certificate-name') }}</td>
            <td class="under"><span></span></td>
            <td class="fit">{{ __('exports.certificate-position') }}</td>
            <td class="under"><span></span></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="fit">{{ __('exports.certificate-footer-text-1') }}</td>
            <td class="under"><span></span></td>
            <td class="fit">-</td>
            <td class="under"><span></span></td>
            <td class="fit">{{ __('exports.certificate-footer-text-2') }}</td>
        </tr>
        <tr>
            <td colspan="5">{{ __('exports.certificate-footer-text-3') }}</td>
        </tr>
    </table>
    <table class="push-left w-4">
        <tr>
            <td class="fit text-right">{{ __('exports.certificate-named') }}</td>
            <td class="under" colspan="2"><span></span></td>
        </tr>
        <tr>
            <td class="fit text-right">(</td>
            <td class="under"><span>{{ $name }}</span></td>
            <td class="fit">)</td>
        </tr>
        <tr>
            <td class="fit text-right"></td>
            <td class="under" colspan="2"><span></span></td>
        </tr>
    </table>
</section>
