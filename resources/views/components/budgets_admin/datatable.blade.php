<section>
    <table id="budgetitems-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("budgetitems.table-serial")}}</th>
                <th>{{__("budgetitems.table-title")}}</th>
                <th>{{__("budgetitems.table-place")}}</th>
                <th>{{__("budgetitems.table-value")}}</th>
                <th>{{__("budgetitems.table-owner")}}</th>
                <th>{{__("budgetitems.table-type")}}</th>
                <th>{{__("budgetitems.table-hasData")}}</th>
                <th>{{__("budgetitems.table-created_at")}}</th>
                <th>{{__("budgetitems.table-action")}}</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#budgetitems-datatable').DataTable({
                    ajax: `{{route('budgets.admin')}}`,
                    columns: [
                        { data: 'budget.serial', width: '5%', render: ff.text},
                        { data: 'budget.title', width: '15%'},
                        { data: 'budget.place', width: '10%'},
                        { data: 'budget.value', width: '10%', render: ff.money},
                        { data: 'user.name', width: '15%'},
                        { data: 'owner', width: '10%', render: (val) => ff.boolean(val, @js(__('budgetitems.table-type-true')), @js(__('budgetitems.table-type-false')))},
                        { data: 'hasData', width: '10%', render: (val) => ff.boolean(val, @js(__('budgetitems.table-hasData-true')), @js(__('budgetitems.table-hasData-false')))},
                        { data: 'created_at', width: '15%', render: ff.dateandtime },
                        { data: 'action', width: '10%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
