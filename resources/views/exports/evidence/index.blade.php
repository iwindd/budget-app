@inject('format', 'App\Services\FormatHelperService')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document 2</title>

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
</head>

<body>
    <h1 class="title">{{ __('exports.evidence-title') }}</h1>

    <section>
        <table class="w-5 push-center">
            <tr>
                <td class="fit">{{__('exports.evidence-header-office')}}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{__('exports.evidence-header-province')}}</td>
                <td class="under"><span></span></td>
            </tr>
        </table>
        <table class="w-8 push-center">
            <tr>
                <td class="fit">{{__('exports.evidence-header-owner')}}</td>
                <td class="under w-4"><span></span></td>
                <td class="fit">{{__('exports.evidence-order_at')}}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{__('exports.evidence-month')}}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{__('exports.evidence-year')}}</td>
                <td class="under"><span></span></td>
            </tr>
        </table>
    </section>

    <section>
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2">{!! __('exports.evidence-table-number') !!}</th>
                    <th class="w-2" rowspan="2">{{ __('exports.evidence-table-name') }}</th>
                    <th class="w-1" rowspan="2">{{ __('exports.evidence-table-position') }}</th>
                    <th colspan="{{$listExpenses->count()}}">{{ __('exports.evidence-table-expenses') }}</th>
                    <th style="width: 5%;" rowspan="2">{{ __('exports.evidence-table-total') }}</th>
                    <th class="w-2" rowspan="2">{{ __('exports.evidence-table-signature') }}</th>
                    <th class="w-1" rowspan="2">{{ __('exports.evidence-table-date') }}</th>
                    <th rowspan="2">{{ __('exports.evidence-table-note') }}</th>
                </tr>
                <tr>
                    @foreach ($listExpenses as $item)
                        <th>{{$item->label}}</th>
                    @endforeach
                </tr>
            </thead>
        </table>
    </section>
</body>

</html>
