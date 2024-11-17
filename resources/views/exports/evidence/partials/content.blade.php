<section>
    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">{!! __('exports.evidence-table-number') !!}</th>
                <th class="w-2" rowspan="2">{{ __('exports.evidence-table-name') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.evidence-table-position') }}</th>
                <th colspan="{{$expenses->count()}}">{{ __('exports.evidence-table-expenses') }}</th>
                <th style="width: 5%;" rowspan="2">{{ __('exports.evidence-table-total') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.evidence-table-signature') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.evidence-table-date') }}</th>
                <th class="w-1" rowspan="2">{{ __('exports.evidence-table-note') }}</th>
            </tr>
            <tr>
                @foreach ($expenses as $item)
                    <th>{{$item->label}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $item)
                @php
                    $expense_total = 0;
                @endphp
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$item->user->name}}</td>
                    <td>{{$item->user->position->label}}</td>
                    @foreach ($expenses as $expense)
                        @php
                            $expense_items = !$expense->default ? (
                                $budgetExpenses->where('expense_id', $expense->id)
                            ): (
                                $budgetExpenses->filter(function($item) {
                                    return $item->expense->merge || $item->expense->default;
                                })
                            );
                            $expense_sum = $expense_items->sum(function ($expense_item) {
                                return $expense_item->total * ($expense_item->days ?? 1);
                            }) / $users->count();
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
                @php
                    $expenses_total = 0;
                @endphp
                @foreach ($expenses as $expense)
                    @php
                        $expense_items = !$expense->default ? (
                            $budgetExpenses->where('expense_id', $expense->id)
                        ): (
                            $budgetExpenses->filter(function($item) {
                                return $item->expense->merge || $item->expense->default;
                            })
                        );
                        $expense_sum = $expense_items->sum(function ($expense_item) {
                            return $expense_item->total * ($expense_item->days ?? 1);
                        });
                        $expenses_total += $expense_sum;
                    @endphp
                    <td>
                        {{$format->number($expense_sum)}}
                    </td>
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
