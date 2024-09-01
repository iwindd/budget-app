<section>
    <table id="offices-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("offices.table-id")}}</th>
                <th>{{__("offices.table-label")}}</th>
                <th>{{__("offices.table-default")}}</th>
                <th>{{__("offices.table-created_by")}}</th>
                <th>{{__("offices.table-created_at")}}</th>
                <th>{{__("offices.table-action")}}</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#offices-datatable').DataTable({
                    ajax: `{{route('offices')}}`,
                    columns: [
                        { data: 'id', width: '5%', render: ff.id},
                        { data: 'label', width: '25%'},
                        { data: 'default', width: '15%', render: (val) => ff.boolean(val, @js(__("offices.col-default-true")), @js(__('offices.col-default-false')))},
                        { data: 'created_by', width: '20%'},
                        { data: 'created_at', width: '20%', render: ff.dateandtime },
                        { data: 'action', width: '15%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
