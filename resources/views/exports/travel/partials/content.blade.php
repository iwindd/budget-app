    <table class="table" style="margin: 1.0em 0;">
        <thead>
            <tr>
                <th rowspan="2">{{ __('exports.travel-table-order') }}</th>
                <th rowspan="2">{{ __('exports.travel-table-plate') }}</th>
                <th colspan="2">{{ __('exports.travel-table-travel') }}</th>
                <th rowspan="2">{{ __('exports.travel-table-vehicle-user') }}</th>
                <th rowspan="2">{{ __('exports.travel-table-place') }}</th>
                <th colspan="2">{{ __('exports.travel-table-back') }}</th>
                <th rowspan="2">{!! __('exports.travel-table-distance') !!}</th>
                <th rowspan="2">{{ __('exports.travel-table-round') }}</th>
                <th rowspan="2">{{ __('exports.travel-table-total-distance') }}</th>
                <th rowspan="2">{!!__('exports.travel-table-bahtperkm')!!}</th>
            </tr>
            <tr>
                <th>{{ __('exports.travel-table-date') }}</th>
                <th>{{ __('exports.travel-table-time') }}</th>
                <th>{{ __('exports.travel-table-date') }}</th>
                <th>{{ __('exports.travel-table-time') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($addresses as $i => $address)
                @php
                    $round = $address['multiple'] ? ($format->dayDiff($address['back_date'], $address['from_date'])+1)*1:1;
                @endphp
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$address['plate']}}</td>
                    <td>{{$format->date($address['from_date'], "j M y")}}</td>
                    <td>{{$format->date($address['from_date'], "H:i")}}</td>
                    <td>{{$name}}</td>
                    <td>{{$header}}</td>
                    <td>{{$format->date($address['back_date'], "j M y")}}</td>
                    <td>{{$format->date($address['back_date'], "H:i")}}</td>
                    <td>{{$format->number($address['distance'], 2)}}กม.</td>
                    <td>{{$format->number($round)}} เที่ยว</td>
                    <td>{{$format->number($address['distance'] * $round, 2)}}กม.</td>
                    <td>{{$format->number($address['distance'] * $round * 4, 2)}}กม.</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
