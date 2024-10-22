<section>
    <h1 class="title">{{ __('exports.travel-title') }}</h1>
    <table class="w-5 push-center">
        <tr>
            <th class="fit text-right">{{ __('exports.travel-office') }}</th>
            <th class="under"><span>{{$office}}</span></th>
            <th class="fit text-right">{{ __('exports.travel-province') }}</th>
            <th class="under"><span>{{$province}}</span></th>
        </tr>
    </table>
    <table class="w-7 push-center">
        <tr>
            <th class="fit text-right">{{ __('exports.travel-user') }}</th>
            <th class="under"><span>{{$name}}</span></th>
            <th class="fit text-right">{{ __('exports.travel-order_at') }}</th>
            <th class="under"><span>{{$format->date($start)}} - {{$format->date($end)}}</span></th>
        </tr>
    </table>
    <table class="w-3 push-center">
        <tr>
            <th class="fit text-right">{{ __('exports.travel-at') }}</th>
            <th class="under"><span>{{$n}}</span></th>
        </tr>
    </table>
</section>
