<section>
    @foreach ($addresses as $address)
        <p>
            @foreach ($locations as $location)
                <span style="white-space: nowrap; margin-rightไ: 0.3em;">[{!!$location['id'] == $address->from_id ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>' : ' '!!}] {{$location['label']}}</span>
            @endforeach

            {{$format->dateAddress($address->from_date, $address->back_date, $address->multiple, [
                'Pd' => __('exports.document-address-from-label'),
                'Pm' => __('exports.document-date-month'),
                'Py' => __('exports.document-date-year'),
                'Pt' => __('exports.document-date-time'),
                'fMain' => true,
            ])}} {{ __('exports.document-date-time-unit') }}
            <br/>
            {{__('exports.document-address-back-label')}}
            @foreach ($locations as $location)
                <span style="white-space: nowrap; margin-right: 0.3em;">[{!! $location['id'] == $address->back_id ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>' : ' ' !!}] {{$location['label']}}</span>
            @endforeach
            {{$format->dateAddress($address->from_date, $address->back_date, $address->multiple, [
                'Pd' => __('exports.document-date'),
                'Pm' => __('exports.document-date-month'),
                'Py' => __('exports.document-date-year'),
                'Pt' => __('exports.document-date-time'),
                'fMain' => false,
            ])}} {{ __('exports.document-date-time-unit') }}

            {{-- {{ __('exports.document-date-time') }} {{ $format->date($address->from_date, 'H:i') }}  --}}
     {{--

            @foreach ($locations as $location)
                <span style="white-space: nowrap; margin-right: 0.3em;">[{!! $location['id'] == $address->back_id ? '<i style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</i>' : ' ' !!}] {{$location['label']}}</span>
            @endforeach
            {{ __('exports.document-date') }} {{ $format->date($address->back_date, 'd') }}
            {{ __('exports.document-date-month') }} {{ $format->date($address->back_date, 'F') }}
            {{ __('exports.document-date-year') }} {{ $format->date($address->back_date, 'Y') }}
            {{ __('exports.document-date-time') }} {{ $format->date($address->back_date, 'H:i') }} {{ __('exports.document-date-time-unit') }} --}}
        </p>
{{--         <table>
            <tbody>
                <tr>
                    <td class="fit">
                        <p></p>
                    </td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'd') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-month') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'F') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-year') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'Y') }}</span></td>

                </tr>
                <tr>
                    <td class="fit">
                        <p>{{ __('exports.document-address-back-label') }}

                        @foreach ($locations as $location)
                            [<span style="font-family: DejaVu Sans, sans-serif; font-size: 10px;">✔</span>]{{$location['label']}}
                        @endforeach</p>
                    </td>
                   <td class="under"><span>{{ $format->date($address->back_date, 'd') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-month') }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'F') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-year') }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'Y') }}</span></td>
                </tr>
            </tbody>
        </table> --}}
    @endforeach
    <table class="w-6">
        <tr>
            <td class="fit">{{ __('exports.document-days-total') }}</td>
            <td class="under"><span>{{ $format->number($days) }}</span></td>
            <td class="fit">{{ __('exports.document-days-day') }}</td>
            <td class="under"><span>{{ $format->number($hours - $days * 24) }}</span></td>
            <td class="fit">{{ __('exports.document-days-hour') }}</td>
        </tr>
    </table>
</section>
