<h1 class="title">{{ __('exports.evidence-title') }}</h1>
<section>
    <p style="float: right; margin-right: 2em;">{{__('exports.evidence-format')}}</p>
    <table class="w-4 push-center">
        <tr>
            <td class="fit">{{__('exports.evidence-header-office')}}</td>
            <td class="under"><span>{{$office}}</span></td>
            <td class="fit">{{__('exports.evidence-header-province')}}</td>
            <td class="under"><span>{{$province}}</span></td>
        </tr>
    </table>
    <table class="w-7 push-center">
        <tr>
            <td class="fit">{{__('exports.evidence-header-owner')}}</td>
            <td class="under w-4"><span>{{$name}}</span></td>
            <td class="fit">{{__('exports.evidence-order_at')}}</td>
            <td class="under"><span>{{ $format->date($date, 'd') }}</span></td>
            <td class="fit">{{__('exports.evidence-month')}}</td>
            <td class="under"><span>{{ $format->date($date, 'F') }}</span></td>
            <td class="fit">{{__('exports.evidence-year')}}</td>
            <td class="under"><span>{{ $format->date($date, 'Y') }}</span></td>
        </tr>
    </table>
</section>
