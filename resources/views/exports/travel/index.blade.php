@inject('format', 'App\Services\FormatHelperService')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ __('exports.travel-title') }}</title>

    <style>
        @font-face {
            font-family: "THSarabun";
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabun.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "THSarabun";
            font-style: normal;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunBold.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "THSarabun";
            font-style: italic;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunItalic.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "THSarabun";
            font-style: italic;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunBoldItalic.ttf') }}") format("truetype");
        }
    </style>
    <link rel="stylesheet" href="{{ public_path('css/export.css') }}">
    <style>
        body {
            padding: 1in 0.5in 1in 0.5in;
        }
    </style>
</head>

<body>
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
    <section>
        <section style="width: 47%; float: left;">
            <p>{{__('exports.travel-footer-text-1')}}</p>
        </section>
        <section style="width: 30%; float: right;">
            <table class="push-center">
                <tr>
                    <td class="fit text-right">{{ __('exports.travel-named') }}</td>
                    <td class="under"><span>{{$name}}</span></td>
                </tr>
                <tr>
                    <td class="fit text-right">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.travel-position') }}</td>
                    <td class="under"><span>{{$position}}</span></td>
                </tr>
            </table>
        </section>
    </section>
</body>

</html>
