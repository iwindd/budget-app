<section>
    <table id="budgetitems-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("budgetitems.table-serial")}}</th>
                <th>{{__("budgetitems.table-title")}}</th>
                <th>{{__("budgetitems.table-place")}}</th>
                <th>{{__("budgetitems.table-value")}}</th>
                <th>{{__("budgetitems.table-created_by")}}</th>
                <th>{{__("budgetitems.table-created_at")}}</th>
                <th>{{__("budgetitems.table-companions-count")}}</th>
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
                        { data: 'serial', width: '5%', render: ff.text},
                        { data: 'title', width: '10%'},
                        { data: 'place', width: '10%'},
                        { data: 'value', width: '15%', render: ff.money},
                        { data: 'user.name', width: '20%'},
                        { data: 'created_at', width: '20%', render: ff.dateandtime },
                        { data: 'budget_items_count', width: '10%', render: (value) => {
                            if (value <= 1) return '-';

                            return `${ff.number(value)} คน`
                        }},
                        { data: 'action', width: '10%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
