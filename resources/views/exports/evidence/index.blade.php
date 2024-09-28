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
    <style>
        body{
            padding: 1in 0.5in 1in 0.5in;
        }
    </style>
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
            <tbody>
                @foreach ($items as $index => $item)
                    @php
                        $expense_total = 0;
                    @endphp
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->user->position->label}}</td>
                        @foreach ($listExpenses as $expense)
                            @php
                                $expense_item = $item->budgetItemExpenses->firstWhere('expense_id', $expense->id);
                                $expense_total += $expense_item->total ?? 0;
                            @endphp
                            <td>{{$format->number($expense_item->total ?? 0)}}</td>
                        @endforeach
                        <td>{{$format->number($expense_total)}}</td>
                        <td>{{-- MANUAL --}}</td>
                        <td>{{-- MANUAL --}}</td>
                        <td>{{-- MANUAL --}}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3">{{__('exports.evidence-table-total-all')}}</th>
                    @php
                        $expenses_total = 0;
                    @endphp
                    @foreach ($listExpenses as $expense)
                        @php
                            $expense_total = 0;
                        @endphp
                        @foreach ($items as $item)
                            @php
                                $expense_item = $item->budgetItemExpenses->firstWhere('expense_id', $expense->id);
                                $expense_total += $expense_item->total ?? 0;
                                $expenses_total += $expense_total;
                            @endphp
                        @endforeach
                        <th>{{$format->number($expense_total)}}</th>
                    @endforeach
                    <th>{{$format->number($expenses_total)}}</th>
                    <td colspan="3">
                        <table class="w-9">
                            <tr>
                                <th class="fit">{{__('exports.evidence-table-serial')}}</th>
                                <td class="under"><span>{{$serial}}</span></td>
                                <th class="fit">{{__('exports.evidence-table-date')}}</th>
                                <td class="under"><span>{{$format->date($date)}}</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
