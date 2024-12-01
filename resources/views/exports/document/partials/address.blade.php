<section>
    @foreach ($addresses as $address)
        <p>
            @foreach ($locations as $location)
                <span style="white-space: nowrap; margin-right: 0.3em;">[{!!$location['id'] == $address['from_id'] ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>' : ' '!!}] {{$location['label']}}</span>
            @endforeach
            {{$format->dateAddress($address['from_date'], $address['back_date'], $address['multiple'], [
                'Pd' => __('exports.document-address-from-label'),
                'Pm' => __('exports.document-date-month'),
                'Py' => __('exports.document-date-year'),
                'Pt' => __('exports.document-date-time'),
                'fMain' => true,
                'noStack' => true,
                '-' => "และ"
            ])}} {{ __('exports.document-date-time-unit') }}
            <br/>
            {{__('exports.document-address-back-label')}}
            @foreach ($locations as $location)
                <span style="white-space: nowrap; margin-right: 0.3em;">[{!! $location['id'] == $address['back_id'] ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>' : ' ' !!}] {{$location['label']}}</span>
            @endforeach
            {{$format->dateAddress($address['from_date'], $address['back_date'], $address['multiple'], [
                'Pd' => __('exports.document-date'),
                'Pm' => __('exports.document-date-month'),
                'Py' => __('exports.document-date-year'),
                'Pt' => __('exports.document-date-time'),
                'fMain' => false,
                'noStack' => true,
                '-' => "และ"
            ])}} {{ __('exports.document-date-time-unit') }}
        </p>
    @endforeach
    <table class="w-6">
        <tr>
            <td class="fit">{{ __('exports.document-days-total') }}</td>
            <td class="under"><span>{{ $format->number(floor($hours / 24)) }}</span></td>
            <td class="fit">{{ __('exports.document-days-day') }}</td>
            <td class="under"><span>{{ $format->number($hours % 24) }}</span></td>
            <td class="fit">{{ __('exports.document-days-hour') }}</td>
        </tr>
    </table>
</section>
