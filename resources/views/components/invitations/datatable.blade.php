<section>
    <table id="invitations-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("invitations.table-id")}}</th>
                <th>{{__("invitations.table-label")}}</th>
                <th>{{__("invitations.table-default")}}</th>
                <th>{{__("invitations.table-created_by")}}</th>
                <th>{{__("invitations.table-created_at")}}</th>
                <th>{{__("invitations.table-action")}}</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#invitations-datatable').DataTable({
                    ajax: `{{route('invitations')}}`,
                    columns: [
                        { data: 'id', width: '5%', render: ff.id},
                        { data: 'label', width: '25%'},
                        { data: 'default', width: '15%', render: (val) => ff.boolean(val, @js(__("invitations.col-default-true")), @js(__('invitations.col-default-false')))},
                        { data: 'created_by', width: '20%'},
                        { data: 'created_at', width: '20%', render: ff.dateandtime },
                        { data: 'action', width: '15%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
