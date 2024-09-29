@inject('format', 'App\Services\FormatHelperService')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ __('exports.document-title') }}</title>

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
            padding: 1in 1in 1in 1in;
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
                <td class="under w-4"><span>{{ $name }}</span></td>
                <td class="fit">{{ __('exports.document-value') }}</td>
                <td class="under"><span>{{ $format->number($value) }}</span></td>
                <td class="fit">{{ __('exports.document-value-suffix') }}</td>
                <td class="fit text-right w-1">{{ __('exports.document-format') }}</td>
            </tr>
        </table>
    </section>
    <h1 class="title" style="margin: 1em 0;">{{ __('exports.document-title') }}</h1>
    <section class="w-4 push-left">
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-office') }}</td>
                <td class="under"><span>{{ $office }}</span></td>
            </tr>
        </table>
        <table class="w-7 push-center">
            <tr>
                <td class="fit">{{ __('exports.document-date-day') }}</td>
                <td class="under"><span>{{ $format->date($date, 'd') }}</span></td>
                <td class="fit">{{ __('exports.document-date-month') }}</td>
                <td class="under"><span>{{ $format->date($date, 'F') }}</span></td>
                <td class="fit">{{ __('exports.document-date-year') }}</td>
                <td class="under"><span>{{ $format->date($date, 'Y') }}</span></td>
            </tr>
        </table>
    </section>
    <section class="w-4">
        <table>
            <tr>
                <td class="fit indent-mini">{{ __('exports.ducument-subject-static') }}</td>
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
                <td class="fit indent">{{ __('exports.document-order_id') }}</td>
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
                <td class="under"><span>{{ $companions[0]->user->name ?? '-' }}
                        {{ $companions->count() > 1 ? ',' : '' }}</span></td>
            </tr>
        </table>
        @if ($companions->count() > 1)
            @foreach ($companions->slice(1)->chunk(3) as $companionChunk)
                <table>
                    <tr>
                        <td class="under text-left">
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
                    <td class="under"><span>{{ $format->date($address->from_date, 'd') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-month') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'F') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-year') }}</td>
                    <td class="under"><span>{{ $format->date($address->from_date, 'Y') }}</span></td>
                    <td class="fit">{{ __('exports.document-address-back-label') }} {{ $address->back->label }}
                    </td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'd') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-month') }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'F') }}</span></td>
                    <td class="fit">{{ __('exports.document-date-year') }}</td>
                    <td class="under"><span>{{ $format->date($address->back_date, 'Y') }}</span></td>
                </tr>
            </table>
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
    <section>
        <table>
            <tr>
                <td class="fit indent">
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
                        <td class="under w-1"><span>{{ $format->number($expense->days) }}</span></td>
                        <td class="fit">{{ __('exports.document-expense-days-suffix') }}</td>
                    @endif

                    <td class="fit">{{ __('exports.document-expense-total') }}</td>
                    <td class="under w-2"><span>{{ $format->number($expense_total) }}</span></td>
                    <td class="fit">{{ __('exports.document-expense-total-suffix') }}</td>
                </tr>
            </table>
        @endforeach
        <table>
            <tr>
                <td class="grow"></td>
                <td class="fit">{{ __('exports.document-expenses-total') }}</td>
                <td class="under w-2"><span>{{ $format->number($total) }}</span></td>
                <td class="fit">{{ __('exports.document-expense-total-suffix') }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-expense-total-text') }}</td>
                <td class="under w-2"><span>{{ $format->bahtText($total) }}</span></td>
            </tr>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit indent">{{ __('exports.document-footer-text') }}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.document-footer-count') }}</td>
                <td class="under w-1"><span></span></td>
                <td class="fit">{{ __('exports.document-footer-count-suffix') }}</td>
                <td class="grow text-left">{{ __('exports.document-footer-count-text') }}</td>
            </tr>
        </table>
    </section>
    <section class="w-4 push-left">
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-named') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-recipient') }}</td>
            </tr>
            <tr>
                <td class="fit text-right">(</td>
                <td class="under"><span></span></td>
                <td class="fit">)</td>
            </tr>
            <tr>
                <td class="fit text-right">{{ __('exports.document-position') }}</td>
                <td class="under"><span></span></td>
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
                    <td class="fit text-right">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit text-right">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
            </table>
        </section>
        <section style="width: 35%; float: right;">
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit text-right">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit"></td>
                </tr>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-date') }}</td>
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
                <td class="fit indent" >{{ __('exports.document-text-3') }}</td>
                <td class="fit">{{ __('exports.document-count') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.document-bath') }}</td>
            </tr>
        </table>
        <table class="w-6" style="margin-bottom: 1em;">
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
                    <td class="fit text-right">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit">{{ __('exports.document-payee') }}</td>
                </tr>
                <tr>
                    <td class="fit text-right">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>

            </table>
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
        </section>
        <section style="width: 47%; float: right;">
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-named') }}</td>
                    <td class="under"><span></span></td>
                    <td class="fit">{{ __('exports.document-payer') }}</td>
                </tr>
                <tr>
                    <td class="fit text-right">(</td>
                    <td class="under"><span></span></td>
                    <td class="fit">)</td>
                </tr>

            </table>
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-position') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td class="fit text-right">{{ __('exports.document-date') }}</td>
                    <td class="under"><span></span></td>
                </tr>
            </table>
        </section>
        <span class="clearfix"></span>
        <table>
            <tr>
                <td class="fit text-right">{{ __('exports.document-text-5') }}</td>
                <td class="under"><span></span></td>
                <td class="fit text-right">{{ __('exports.document-date') }}</td>
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
