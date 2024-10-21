@inject('format', 'App\Services\FormatHelperService')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ __('exports.evidence-title') }}</title>

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
    @php
        $expenses_total = 0;
    @endphp

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

    <section>
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2">{!! __('exports.evidence-table-number') !!}</th>
                    <th class="w-2" rowspan="2">{{ __('exports.evidence-table-name') }}</th>
                    <th class="w-1" rowspan="2">{{ __('exports.evidence-table-position') }}</th>
                    <th colspan="{{$listExpenses->count()}}">{{ __('exports.evidence-table-expenses') }}</th>
                    <th style="width: 5%;" rowspan="2">{{ __('exports.evidence-table-total') }}</th>
                    <th class="w-1" rowspan="2">{{ __('exports.evidence-table-signature') }}</th>
                    <th class="w-1" rowspan="2">{{ __('exports.evidence-table-date') }}</th>
                    <th class="w-1" rowspan="2">{{ __('exports.evidence-table-note') }}</th>
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
                                $budgetItemExpenses = $item->budgetItemExpenses;
                                $expense_items = !$expense->default ? (
                                    $budgetItemExpenses->where('expense_id', $expense->id)
                                ): (
                                    $budgetItemExpenses->filter(function($item) {
                                        return $item->expense->merge || $item->expense->default;
                                    })
                                );
                                $expense_sum = $expense_items->sum(function ($expense_item) {
                                    return $expense_item->total * ($expense_item->days ?? 1);
                                });
                                $expense_total += $expense_sum;
                            @endphp
                            <td>
                                {{$format->number($expense_sum)}}
                            </td>
                        @endforeach
                        <td>{{$format->number($expense_total)}}</td>
                        <td>{{-- MANUAL --}}</td>
                        <td>{{$format->date($item->date)}}</td>
                        <td>{{-- MANUAL --}}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3">{{__('exports.evidence-table-total-all')}}</th>
                    @foreach ($listExpenses as $expense)
                        @php
                            $expense_total = 0;
                        @endphp
                        @foreach ($items as $item)
                            @php
                                $budgetItemExpenses = $item->budgetItemExpenses;
                                $expense_items = !$expense->default ? (
                                    $budgetItemExpenses->where('expense_id', $expense->id)
                                ): (
                                    $budgetItemExpenses->filter(function($item) {
                                        return $item->expense->merge || $item->expense->default;
                                    })
                                );

                                $expense_total += $expense_items->sum(function ($expense_item) {
                                    return $expense_item->total * ($expense_item->days ?? 1);
                                });
                            @endphp
                        @endforeach
                        @php
                            $expenses_total += $expense_total;
                        @endphp
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

    <section style="margin-top: 1em;">
        <section style="float:left;" class="w-6">
            <table class="push-left w-8">
                <tr>
                    <td class="fit">{{ __('exports.evidence-total-money') }}</td>
                    <td class="under"><span>{{$format->bahtText($expenses_total)}}</span></td>
                </tr>
            </table>
            <table class="text-sm-all" style="overflow: hidden;">
                <tr>
                    <td class="fit underline" style="vertical-align: top;">{{ __('exports.evidence-explanation') }}</td>
                    <td class="fit" style="vertical-align: top; padding: 0 0.2em;">1.</td>
                    <td class="grow" style="text-align: left; vertical-align: top;">
                        {{ __('exports.evidence-explanation-1') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="fit" style="vertical-align: top; padding: 0 0.2em;">2.</td>
                    <td class="grow" style="text-align: left; vertical-align: top;">
                        {{ __('exports.evidence-explanation-2') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="fit" style="vertical-align: top; padding: 0 0.2em;">3.</td>
                    <td class="grow" style="text-align: left; vertical-align: top;">
                        {{ __('exports.evidence-explanation-3') }}</td>
                </tr>
            </table>
        </section>
        <section style="float:right;" class="w-4">
            <table class="push-center w-8">
                <tr>
                    <td class="fit text-right">{{ __('exports.document-named') }}</td>
                    <td class="under"><span>{{$name}}</span></td>
                    <td class="fit">{{ __('exports.document-payer') }}</td>
                </tr>
                <tr>
                    <td class="fit text-right">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-position') }}</td>
                    <td class="under"><span>{{$position}}</span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
            </table>
        </section>
    </section>
</body>

</html>
