<section>
    <table id="locations-datatable" class="display">
        <thead>
            <tr>
                <th>{{__("locations.table-id")}}</th>
                <th>{{__("locations.table-label")}}</th>
                <th>{{__("locations.table-created_by")}}</th>
                <th>{{__("locations.table-created_at")}}</th>
                <th>{{__("locations.table-action")}}</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#locations-datatable').DataTable({
                    ajax: `{{route('locations')}}`,
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
