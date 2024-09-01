<section>
    <table id="expenses-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("expenses.table-id")}}</th>
                <th>{{__("expenses.table-label")}}</th>
                <th>{{__("expenses.table-created_by")}}</th>
                <th>{{__("expenses.table-created_at")}}</th>
                <th>{{__("expenses.table-action")}}</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#expenses-datatable').DataTable({
                    ajax: `{{route('expenses')}}`,
                    columns: [
                        { data: 'id', width: '5%', render: ff.id},
                        { data: 'label', width: '30%'},
                        { data: 'created_by', width: '25%'},
                        { data: 'created_at', width: '25%', render: ff.dateandtime },
                        { data: 'action', width: '15%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
