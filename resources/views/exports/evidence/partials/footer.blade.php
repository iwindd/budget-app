
<section style="margin-top: 1em;">
    <section style="float:left;" class="w-6">
        <table class="push-left w-8">
            <tr>
                <td class="fit">{{ __('exports.evidence-total-money') }}</td>
                <td class="under"><span>{{$format->bahtText($expenses_total)}}</span></td>
            </tr>
        </table>
        <table class="text-sm-all" style="overflow: hidden;">
            <tr>
                <td class="fit underline" style="vertical-align: top;">{{ __('exports.evidence-explanation') }}</td>
                <td class="fit" style="vertical-align: top; padding: 0 0.2em;">1.</td>
                <td class="grow" style="text-align: left; vertical-align: top;">
                    {{ __('exports.evidence-explanation-1') }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="fit" style="vertical-align: top; padding: 0 0.2em;">2.</td>
                <td class="grow" style="text-align: left; vertical-align: top;">
                    {{ __('exports.evidence-explanation-2') }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="fit" style="vertical-align: top; padding: 0 0.2em;">3.</td>
                <td class="grow" style="text-align: left; vertical-align: top;">
                    {{ __('exports.evidence-explanation-3') }}</td>
            </tr>
        </table>
    </section>
    <section style="float:right;" class="w-4">
        <table class="push-center w-8">
            <tr>
                <td class="fit text-right">{{ __('exports.document-named') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-payer') }}</td>
            </tr>
            <tr>
                <td class="fit text-right">(</td>
                <td class="under"><span>{{$name}}</span></td>
                <td class="fit">)</td>
            </tr>
            <tr>
                <td class="fit text-right">{{ __('exports.document-position') }}</td>
                <td class="under"><span>{{$position}}</span></td>
                <td class="fit"></td>
            </tr>
            <tr>
                <td class="fit text-right">{{ __('exports.document-date') }}</td>
                <td class="under"><span></span></td>
                <td class="fit"></td>
            </tr>
        </table>
    </section>
</section>
