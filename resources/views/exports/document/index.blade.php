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

        td.under,
        td.grow {
            position: relative;
            text-align: center
        }

        td.under.fix {
            font-size: 16px;
            height: 20px;
            line-height: 1em;
        }

        td.fix-under {
            color: rgba(255, 255, 255, 0);
            width: 0px;
            background-color: red;
        }

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

        .clearfix {
            content: "";
            display: table;
            clear: both;
        }

        section {
            page-break-inside: avoid;
        }

        .bold {
            font-weight: bold
        }

        .underline {
            text-decoration: underline;
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
                <td class="under"><span>{{ $format->date($date) }}</span></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-name') }}</td>
                <td class="under" style="width: 50%;"><span>{{ $name }}</span></td>
                <td class="fit">{{ __('exports.document-value') }}</td>
                <td class="under"><span>{{ $format->number($value) }}</span></td>
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
        </table>
        <table style="width: 70%; margin: 0 auto;">
            <tr>
                <td class="fit">{{__('exports.document-date-day')}}</td>
                <td class="under"><span>{{ $format->date($date, 'd') }}</span></td>
                <td class="fit">{{__('exports.document-date-month')}}</td>
                <td class="under"><span>{{ $format->date($date, 'F') }}</span></td>
                <td class="fit">{{__('exports.document-date-year')}}</td>
                <td class="under"><span>{{ $format->date($date, 'Y') }}</span></td>
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
                <td class="under"><span>{{ $format->date($order_at) }}</span></td>
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
                    <td class="fit">{{ $address->from->label }} {{ __('exports.document-address-from-label') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'd') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-month') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'F') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-year') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'Y') }}</span></td>
                    <td class="fit">{{ __('exports.document-address-back-label') }} {{ $address->back->label }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'd') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-month') }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'F') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-year') }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'Y') }}</span></td>
                </tr>
            </table>
        @endforeach
        <table style="width: 60%;">
            <tr>
                <td class="fit">{{ __('exports.document-days-total') }}</td>
                <td class="under"><span>{{ $format->number($days) }}</span></td>
                <td class="fit">{{ __('exports.document-days-day') }}</td>
                <td class="under"><span>{{ $format->number($hours - $days * 24) }}</span></td>
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
                        <td class="fit">{{ __('exports.document-expense-days') }}</td>
                        <td class="under" style="width: 15%;"><span>{{ $format->number($expense->days) }}</span></td>
                        <td class="fit">{{ __('exports.document-expense-days-suffix') }}</td>
                    @endif

                    <td class="fit">{{ __('exports.document-expense-total') }}</td>
                    <td class="under" style="width: 20%;"><span>{{ $format->number($expense_total) }}</span></td>
                    <td class="fit">{{ __('exports.document-expense-total-suffix') }}</td>
                </tr>
            </table>
        @endforeach
        <table>
            <tr>
                <td class="grow"></td>
                <td class="fit">{{ __('exports.document-expenses-total') }}</td>
                <td class="under" style="width: 20%;"><span>{{ $format->number($total) }}</span></td>
                <td class="fit">{{ __('exports.document-expense-total-suffix') }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-expense-total-text') }}</td>
                <td class="under" style="width: 20%;"><span>{{ $total }}</span></td>
            </tr>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit" style="padding-left: 2em">{{ __('exports.document-footer-text') }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-footer-count') }}</td>
                <td class="under" style="width: 10%;"><span></span></td>
                <td class="fit">{{ __('exports.document-footer-count-suffix') }}</td>
                <td class="grow" style="text-align: left;">{{ __('exports.document-footer-count-text') }}</td>
            </tr>
        </table>
    </section>
    <section style="width: 40%; margin-left:auto">
        <table>
            <tr>
                <td class="fit" style="text-align: right;">{{ __('exports.document-named') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-recipient') }}</td>
            </tr>
            <tr>
                <td class="fit" style="text-align: right;">(</td>
                <td class="under"><span></span></td>
                <td class="fit">)</td>
            </tr>
            <tr>
                <td class="fit" style="text-align: right;">{{ __('exports.document-position') }}</td>
                <td class="under"><span>{{ $position }}</span></td>
                <td class="fit"></td>
            </tr>
        </table>
    </section>
    <section>
        <section style="width: 35%; float: left;">
            <p>{{ __('exports.document-text-1') }}</p>
        </section>
        <section style="width: 35%; float: right;">
            <p>{{ __('exports.document-text-2') }}</p>
        </section>
        <span class="clearfix"></span>
        <section style="width: 35%; float: left;">
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
            </table>
        </section>
        <section style="width: 35%; float: right;">
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
            </table>
        </section>
        <span class="clearfix"></span>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit" style="padding-left: 2em">{{ __('exports.document-text-3') }}</td>
                <td class="fit">{{ __('exports.document-count') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-bath') }}</td>
            </tr>
        </table>
        <table style="width: 60%; margin-bottom: 1em;">
            <tr>
                <td class="fit">(</td>
                <td class="under"></td>
                <td class="fit">)</td>
                <td class="fit">{{ __('exports.document-text-4') }}</td>
            </tr>
        </table>
        <section style="width: 47%; float: left;">
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit">{{ __('exports.document-payee') }}</td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>

            </table>
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
        </section>
        <section style="width: 47%; float: right;">
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit">{{ __('exports.document-payer') }}</td>
                </tr>
                <tr>
                    <td class="fit" style="text-align: right;">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>

            </table>
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="fit" style="text-align: right;">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
        </section>
        <span class="clearfix"></span>
        <table>
            <tr>
                <td class="fit" style="text-align: right;">{{ __('exports.document-text-5') }}</td>
                <td class="under"><span></span></td>
                <td class="fit" style="text-align: right;">{{ __('exports.document-date') }}</td>
                <td class="under"><span></span></td>
            </tr>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit bold underline">{{ __('exports.document-note') }}</td>
                <td class="under"></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="under fix"></td>
            </tr>
            <tr>
                <td class="under fix"></td>
            </tr>
            <tr>
                <td class="under fix"></td>
            </tr>
            <tr>
                <td class="under fix"></td>
            </tr>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit underline" style="vertical-align: top;">{{ __('exports.document-explanation') }}</td>
                <td class="fit" style="vertical-align: top; padding: 0 0.2em;">1.</td>
                <td class="grow" style="text-align: left; vertical-align: top;">
                    {{ __('exports.document-explanation-1') }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="fit" style="vertical-align: top; padding: 0 0.2em;">2.</td>
                <td class="grow" style="text-align: left; vertical-align: top;">
                    {{ __('exports.document-explanation-2') }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="fit" style="vertical-align: top; padding: 0 0.2em;">3.</td>
                <td class="grow" style="text-align: left; vertical-align: top;">
                    {{ __('exports.document-explanation-3') }}</td>
            </tr>
        </table>
    </section>
</body>

</html>
