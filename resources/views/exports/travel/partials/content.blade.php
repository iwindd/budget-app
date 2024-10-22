<section style="margin: 1.5em 0;">
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">{{ __('exports.travel-table-order') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.travel-table-plate') }}</th>
                <th class="w-1" colspan="2">{{ __('exports.travel-table-travel') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.travel-table-vehicle-user') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.travel-table-place') }}</th>
                <th class="w-1" colspan="2">{{ __('exports.travel-table-back') }}</th>
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
            @foreach ($rows as $index => $row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$row->plate}}</td>
                    <td colspan="2">{{$format->date($row->start, "d F Y H:i")}}</td>
                    <td>{{$row->driver}}</td>
                    <td>{{$row->location}}</td>
                    <td colspan="2">{{$format->date($row->end, "d F Y H:i")}}</td>
                    <td>{{$format->number($row->distance)}}</td>
                    <td>{{$format->number($row->round)}}</td>
                    <td>{{$format->number($row->distance * $row->round)}}</td>
                    <td>{{$format->number(($row->distance * $row->round)*4)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
