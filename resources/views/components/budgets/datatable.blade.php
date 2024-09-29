<section>
    <table id="budgetitems-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("budgetitems.table-serial")}}</th>
                <th>{{__("budgetitems.table-order_id")}}</th>
                <th>{{__("budgetitems.table-subject")}}</th>
                <th>{{__("budgetitems.table-value")}}</th>
                <th>{{__("budgetitems.table-created_by")}}</th>
                <th>{{__("budgetitems.table-created_at")}}</th>
                <th>{{__("budgetitems.table-hasData")}}</th>
                <th>{{__("budgetitems.table-action")}}</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#budgetitems-datatable').DataTable({
                    ajax: `{{route('budgets')}}`,
                    columns: [
                        { data: 'budget.serial', width: '5%', render: ff.text},
                        { data: 'budget.order_id', width: '10%'},
                        { data: 'budget.subject', width: '10%'},
                        { data: 'budget.value', width: '15%', render: ff.money},
                        { data: 'budget.user.name', width: '20%'},
                        { data: 'created_at', width: '20%', render: ff.dateandtime },
                        { data: 'hasData', width: '10%', render: (val) => ff.boolean(val,
                            @js(__('budgetitems.table-hasData-true')),
                            @js(__('budgetitems.table-hasData-false')))
                        },
                        { data: 'action', width: '10%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
