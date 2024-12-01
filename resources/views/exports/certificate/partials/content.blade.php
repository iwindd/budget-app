    <table class="table" style="margin: 1.5em 0;">
        <thead>
            <tr>
                <th class="w-1" style="height: 2em;">{{ __('exports.certificate-table-date') }}</th>
                <th class="w-4">{{ __('exports.certificate-table-detail') }}</th>
                <th class="w-1">{{ __('exports.certificate-table-value') }}</th>
                <th class="w-1">{{ __('exports.certificate-table-note') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td >{{-- EMPTY --}}</td>
                <td class="text-left" style="text-align: left; padding: 0.3em;">
                    {{$subject}} ออกเดินทางไป {{$header}}
                </td>
                <td>{{-- EMPTY --}}</td>
                <td>{{-- EMPTY --}}</td>
            </tr>
            @php
                $sum = 0;
            @endphp
            @foreach ($addresses as $address)
                <tr>
                    <td style="padding: 0.2em; vertical-align: top;">
                        <p>{{
                            $format->dateAddress($address['from_date'], $address['back_date'], $address['multiple'], [
                                'M' => true,
                                'y' => true,
                                'j' => true,
                                'Dt' => true,
                            ])
                        }}</p>
                        @if (!$address['multiple'])
                            จนถึง
                            <p>{{
                                $format->dateAddress($address['from_date'], $address['back_date'], $address['multiple'], [
                                    'M' => true,
                                    'y' => true,
                                    'j' => true,
                                    'Dt' => true,
                                    'fMain' => false
                                ])
                            }}</p>
                        @endif
                    </td>
                    @php
                        $round = $address['multiple'] ? ($format->dayDiff($address['back_date'], $address['from_date'])+1)*1:1;
                        $total = ($address['distance'] * $round) * 4;
                        $sum  += $total;
                    @endphp
                    <td style="text-align: left; padding: 0.2em; vertical-align: top;">
                        <p>
                            - {{$address['show_as']}} {{$name}} โดยรถทะเบียน {{$address['plate']}} เดินทางจาก {{$locations->where('id', $address['from_id'])->first()['label'] ?? 'ERROR'}} เวลา {{$format->date($address['from_date'], 'H:i')}}น. ไป {{$header}} และกลับถึง {{$locations->where('id', $address['back_id'])->first()['label'] ?? 'ERROR'}}  เวลา {{$format->date($address['back_date'], 'H:i')}}น.
                        </p>
                        <span>({{$format->number($address['distance'], 2)}}กม. x 4บาท x {{$round}}เที่ยว รวมเป็นเงิน {{
                            $format->number($total, 2)
                        }}บาท)</span>
                    </td>
                    <td style="padding: 0.2em; vertical-align: top;">{{$format->number($total, 2)}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th>{{$format->bahtText($sum)}}</th>
                <th>{{$format->number($sum, 2)}}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</section>
@include('exports.certificate.partials.footer')
