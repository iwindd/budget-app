{{-- ฉบับ --}}
<section>
    <table>
        <tr>
            <td class="fit indent">{{ __('exports.document-footer-text') }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-footer-count') }}</td>
            <td class="under w-1"><span></span></td>
            <td class="fit">{{ __('exports.document-footer-count-suffix') }}</td>
            <td class="grow text-left">{{ __('exports.document-footer-count-text') }}</td>
        </tr>
    </table>
</section>
{{-- ลายเซ็น 1 --}}
<section class="w-4 push-left page-break" style="margin-top: 2em;">
    <table>
        <tr>
            <td class="fit text-right">{{ __('exports.document-named') }}</td>
            <td class="under"><span></span></td>
            <td class="fit">{{ __('exports.document-recipient') }}</td>
        </tr>
        <tr>
            <td class="fit text-right">(</td>
            <td class="under"><span>{{ $name }}</span></td>
            <td class="fit">)</td>
        </tr>
        <tr>
            <td class="fit text-right">{{ __('exports.document-position') }}</td>
            <td class="under"><span>{{ $position }}</span></td>
            <td class="fit"></td>
        </tr>
    </table>
</section>
{{-- ลายเซ็น 2 --}} {{-- PAGE 2 --}}
<section>
    <table style="width: 100%; height: 1px; margin-bottom: -0.75em;">
        <tr>
            <td style="width: 100%"><hr class="dotted-hr"></td>
            <td>ได้</td>
        </tr>
    </table>
    <table style="border-collapse: collapse; margin: 0.25em 0;">
        <tr>
            <td style="width: 50%; border-right: 1px solid black;  vertical-align: top;">{{ __('exports.document-text-1') }}</td>
            <td style="width: 50%; padding-left: 1em;  vertical-align: top;">{{ __('exports.document-text-2') }}</td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black; padding-right: 1em;">
                <section style="width: 100%; ">
                    <table>
                        <tr>
                            <td class="fit text-right">{{ __('exports.document-named') }}</td>
                            <td class="under"><span></span></td>
                            <td class="fit"></td>
                        </tr>
                        <tr>
                            <td class="fit text-right">(</td>
                            <td class="under"><span></span></td>
                            <td class="fit">)</td>
                        </tr>
                        <tr>
                            <td class="fit text-right">{{ __('exports.document-position') }}</td>
                            <td class="under"><span></span></td>
                            <td class="fit"></td>
                        </tr>
                        <tr>
                            <td class="fit text-right">{{ __('exports.document-date') }}</td>
                            <td class="under"><span></span></td>
                            <td class="fit"></td>
                        </tr>
                    </table>
                </section>
            </td>
            <td style="padding-left: 1em; padding-right: 1em;">
                <table>
                    <tr>
                        <td class="fit text-right">{{ __('exports.document-named') }}</td>
                        <td class="under"><span></span></td>
                        <td class="fit"></td>
                    </tr>
                    <tr>
                        <td class="fit text-right">(</td>
                        <td class="under"><span></span></td>
                        <td class="fit">)</td>
                    </tr>
                    <tr>
                        <td class="fit text-right">{{ __('exports.document-position') }}</td>
                        <td class="under"><span></span></td>
                        <td class="fit"></td>
                    </tr>
                    <tr>
                        <td class="fit text-right">{{ __('exports.document-date') }}</td>
                        <td class="under"><span></span></td>
                        <td class="fit"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr class="clearfix"></span>
</section>
{{-- สรุป & ลายเซ็น 3 --}}
<section>
    <table>
        <tr>
            <td class="fit indent">{{ __('exports.document-text-3') }}</td>
            <td class="fit">{{ __('exports.document-count') }}</td>
            <td class="under"><span>{{ $format->number($value) }}</span></td>
            <td class="fit">{{ __('exports.document-bath') }}</td>
        </tr>
    </table>
    <table class="w-6" style="margin-bottom: 1em;">
        <tr>
            <td class="fit">(</td>
            <td class="under"><span>{{ $format->bahtText($value) }}</span></td>
            <td class="fit">)</td>
            <td class="fit">{{ __('exports.document-text-4') }}</td>
        </tr>
    </table>
    <section style="width: 47%; float: left;">
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-named') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-payee') }}</td>
            </tr>
            <tr>
                <td class="fit text-right">(</td>
                <td class="under"><span>{{ $name }}</span></td>
                <td class="fit">)</td>
            </tr>

        </table>
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-position') }}</td>
                <td class="under"><span>{{ $position }}</span></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-date') }}</td>
                <td class="under"><span></span></td>
            </tr>
        </table>
    </section>
    <section style="width: 47%; float: right;">
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-named') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-payer') }}</td>
            </tr>
            <tr>
                <td class="fit text-right">(</td>
                <td class="under"><span>{{ $owner }}</span></td>
                <td class="fit">)</td>
            </tr>

        </table>
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-position') }}</td>
                <td class="under"><span>{{ $owner_position }}</span></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-date') }}</td>
                <td class="under"><span></span></td>
            </tr>
        </table>
    </section>
    <span class="clearfix"></span>
    <table>
        <tr>
            <td class="fit text-right">{{ __('exports.document-text-5') }}</td>
            <td class="under"><span>{{ $order }}</span></td>
            <td class="fit text-right">{{ __('exports.document-date') }}</td>
            <td class="under"><span>{{ $format->date($order_at) }}</span></td>
        </tr>
    </table>
</section>
{{-- หมายเหตุ --}}
<section>
    <table>
        <tr>
            <td class="fit bold underline">{{ __('exports.document-note') }}</td>
            <td class="under"></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="under fix"></td>
        </tr>
        <tr>
            <td class="under fix"></td>
        </tr>
        <tr>
            <td class="under fix"></td>
        </tr>
        <tr>
            <td class="under fix"></td>
        </tr>
    </table>
</section>
