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
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabun.ttf') }}") format('truetype')
        }

        @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunBold.ttf') }}") format('truetype')
        }

        @font-face {
            font-family: 'THSarabun';
            font-style: italic;
            font-weight: normal;
            src: url("{{ storage_path('fonts/THSarabunItalic.ttf') }}") format('truetype')
        }

        @font-face {
            font-family: 'THSarabun';
            font-style: italic;
            font-weight: bold;
            src: url("{{ storage_path('fonts/THSarabunBoldItalic.ttf') }}") format('truetype')
        }

        * {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
        }

        body {
            padding: 1in 1in 1in 1in;
            line-height: 1em;
        }

        body,
        .text {
            font-family: 'THSarabun';
            font-size: 16px;
        }

        .title {
            font-family: 'THSarabun';
            font-size: 16px;
            text-align: center;
            margin: 1em 0;
        }

        .subtitle {
            font-family: 'THSarabun';
            font-size: 16px;
            font-weight: bold;
        }

        header {
            height: 100%;
        }

        table {
            width: 100%;
        }

        td.fit {
            width: 1%;
            white-space: nowrap;
        }

        td.under, td.grow {
            position: relative;
            text-align: center
        }

        ,
        td.under>span {
            position: relative;
            bottom: 0.15em;
        }

        td.under::after {
            content: "-";
            color: rgba(0, 0, 0, 0);
            position: absolute;
            top: -0.30em;
            ;
            left: 0;
            width: 100%;
            z-index: 1;
            border-bottom: 1px dotted black;
        }
    </style>
</head>

<body>
    <section>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-serial') }}</td>
                <td class="under"><span>{{ $serial }}</span></td>
                <td class="fit">{{ __('exports.document-date') }}</td>
                <td class="under"><span>{{ $date }}</span></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-name') }}</td>
                <td class="under" style="width: 50%;"><span>{{ $name }}</span></td>
                <td class="fit">{{ __('exports.document-value') }}</td>
                <td class="under"><span>{{ $value }}</span></td>
                <td class="fit">{{ __('exports.document-value-suffix') }}</td>
                <td class="fit" style="width: 10%; text-align: right;">{{ __('exports.document-format') }}</td>
            </tr>
        </table>
    </section>
    <h1 class="title">{{ __('exports.document-title') }}</h1>
    <section style="width: 40%; margin-left:auto">
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-office') }}</td>
                <td class="under"><span>{{ $office }}</span></td>
            </tr>
            <tr>
                <td class="fit"></td>
                <td style="text-align: center">
                    <p>วัน.เดือน.ปี</p>
                </td>
            </tr>
        </table>
    </section>
    <section style="width: 40%;">
        <table>
            <tr>
                <td class="fit" style="padding-right: 0.5em;">{{ __('exports.ducument-subject-static') }}</td>
                <td>{{ __('exports.document-subject-static-text') }}</td>
            </tr>
            <tr>
                <td class="fit">{{ __('exports.document-invitation') }}</td>
                <td class="under"><span>{{ $invitation }}</span></td>
            </tr>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit" style="padding-left: 2em">{{ __('exports.document-order_id') }}</td>
                <td class="under"><span>{{ $order_id }}</span></td>
                <td class="fit">{{ __('exports.document-order_at') }}</td>
                <td class="under"><span>{{ $order_at }}</span></td>
                <td class="fit">{{ __('exports.document-allowed') }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-name-2') }}</td>
                <td class="under"><span>{{ $name }}</span></td>
                <td class="fit">{{ __('exports.document-position') }}</td>
                <td class="under"><span>{{ $position }}</span></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-affiliation') }}</td>
                <td class="under"><span>{{ $affiliation }}</span></td>
                <td class="fit">{{ __('exports.document-companions') }}</td>
                <td class="under"><span>{{ $companions[0]->user->name }}
                        {{ $companions->count() > 1 ? ',' : '' }}</span></td>
            </tr>
        </table>
        @if ($companions->count() > 1)
            @foreach ($companions->slice(1)->chunk(3) as $companionChunk)
                <table>
                    <tr>
                        <td class="under" style="text-align: left">
                            <span>
                                {{ $companionChunk->pluck('user.name')->implode(', ') }}
                            </span>
                        </td>
                    </tr>
                </table>
            @endforeach
        @endif
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-subject') }}</td>
                <td class="under"><span>{{ $subject }}</span></td>
                <td class="fit">{{ __('exports.document-subject-suffix') }}</td>
            </tr>
        </table>
    </section>
    <section>
        @foreach ($addresses as $address)
            <table>
                <tr>
                    <td class="fit">{{ $address->from->label }} {{ __('exports.document-address-from-label') }}
                    </td>
                    <td class="under"><span>{{ $address->from_date }}</span></td>
                    <td class="fit">{{ __('exports.document-address-back-label') }} {{ $address->back->label }}
                    </td>
                    <td class="under"><span>{{ $address->back_date }}</span></td>
                </tr>
            </table>
        @endforeach
        <table style="width: 60%;">
            <tr>
                <td class="fit">{{ __('exports.document-days-total') }}</td>
                <td class="under"><span>{{ $days }}</span></td>
                <td class="fit">{{ __('exports.document-days-day') }}</td>
                <td class="under"><span>{{ $hours - $days * 24 }}</span></td>
                <td class="fit">{{ __('exports.document-days-hour') }}</td>
            </tr>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit" style="padding-left: 2em">
                    {{ __('exports.document-expense-header', [
                        'value' =>
                            $companions->count() > 0
                                ? __('exports.document-expense-header-companion')
                                : __('exports.document-expense-header-user'),
                    ]) }}
                </td>
            </tr>
        </table>

        @php
            $total = 0;
        @endphp

        @foreach ($expenses as $expense)
            @php
                $expense_total = $expense->total * ($expense->days ?? 1);
                $total += $expense_total;
            @endphp
            <table>
                <tr>
                    <td class="fit">{{ $expense->expense->label }}</td>
                    <td class="under"></td>

                    @if ($expense->days != null)
                        <td class="fit">{{__('exports.document-expense-days')}}</td>
                        <td class="under" style="width: 15%;"><span>{{ $expense->days }}</span></td>
                        <td class="fit">{{__('exports.document-expense-days-suffix')}}</td>
                    @endif

                    <td class="fit">{{__('exports.document-expense-total')}}</td>
                    <td class="under" style="width: 20%;"><span>{{ $expense_total }}</span></td>
                    <td class="fit">{{__('exports.document-expense-total-suffix')}}</td>
                </tr>
            </table>
        @endforeach
        <table>
            <tr>
                <td class="grow"></td>
                <td class="fit">{{__('exports.document-expenses-total')}}</td>
                <td class="under" style="width: 20%;"><span>{{$total}}</span></td>
                <td class="fit">{{__('exports.document-expense-total-suffix')}}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{__('exports.document-expense-total-text')}}</td>
                <td class="under" style="width: 20%;"><span>{{$total}}</span></td>
            </tr>
        </table>
    </section>
</body>

</html>
