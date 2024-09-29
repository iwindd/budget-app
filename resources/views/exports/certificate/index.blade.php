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
        body {
            padding: 0.5in 1in 1in 1in;
        }
    </style>
</head>

<body>
    <section>
        <p class="text-right">{{ __('exports.certificate-format') }}</p>
        <h1 class="title">{{ __('exports.certificate-title') }}</h1>
        <table class="w-6 push-center">
            <tr>
                <td class="fit">{{ __('exports.certificate-office') }}</td>
                <td class="under"><span>{{ $office }}</span></td>
            </tr>
        </table>
    </section>
    <section>
        <table class="table">
            <thead>
                <tr>
                    <th class="w-2" style="height: 2em;">{{ __('exports.certificate-table-date') }}</th>
                    <th class="w-4">{{ __('exports.certificate-table-detail') }}</th>
                    <th class="w-2">{{ __('exports.certificate-table-value') }}</th>
                    <th class="w-2">{{ __('exports.certificate-table-note') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td class="fit" style="height: 1.5em;"></td>
                        <td class="fit">{{ $expense->expense->label }}</td>
                        <td class="fit">{{ $format->number($expense->total * $expense->days ?? 1) }}</td>
                        <td class="fit"></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="height: 2em; vertical-align: middle;">
                        {{ __('exports.certificate-table-total') }}</th>
                    <th class="fit" style="vertical-align: middle;">{{ $format->number($total) }}</th>
                    <th class="fit"></th>
                </tr>
            </tfoot>
        </table>
    </section>
    <section>
        <table>
            <tr>
                <td class="fit indent">{{ __('exports.certificate-total-text') }}</td>
                <td class="under" colspan="3"><span>{{ $format->bahtText($total) }}</span></td>
            </tr>
            <tr>
                <td class="fit text-right">{{ __('exports.certificate-name') }}</td>
                <td class="under"><span>{{ $name }}</span></td>
                <td class="fit">{{ __('exports.certificate-position') }}</td>
                <td class="under"><span>{{ $position }}</span></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="fit">{{ __('exports.certificate-footer-text-1') }}</td>
                <td class="under"><span></span></td>
                <td class="fit">-</td>
                <td class="under"><span></span></td>
                <td class="fit">{{ __('exports.certificate-footer-text-2') }}</td>
            </tr>
            <tr>
                <td colspan="5">{{ __('exports.certificate-footer-text-3') }}</td>
            </tr>
        </table>
        <table class="push-left w-4">
            <tr>
                <td class="fit text-right">{{ __('exports.certificate-named') }}</td>
                <td class="under" colspan="2"><span></span></td>
            </tr>
            <tr>
                <td class="fit text-right">(</td>
                <td class="under"><span></span></td>
                <td class="fit">)</td>
            </tr>
            <tr>
                <td class="fit text-right"></td>
                <td class="under" colspan="2"><span></span></td>
            </tr>
        </table>
    </section>
</body>

</html>
