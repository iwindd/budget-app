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
        body {
            padding: 1in 1in 1in 1in;
        }
    </style>
</head>

<body>
    @php
        $total = 0;
        $expenses->push($defaultExpense);
    @endphp
    @include('exports.document.partials.header')
    @include('exports.document.partials.budget-header')
    @include('exports.document.partials.budget-content')
    @include('exports.document.partials.address')
    @include('exports.document.partials.expense')
    @include('exports.document.partials.footer')
    @include('exports.document.partials.footer-explanation')
</body>

</html>
