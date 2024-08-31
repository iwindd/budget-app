<section>
    <table id="positions-datatable" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>ตำแหน่ง</th>
                <th>ผู้ใช้</th>
                <th>เพิ่มโดย</th>
                <th>เพิ่มเมื่อ</th>
                <th>เครื่องมือ</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#positions-datatable').DataTable({
                    ajax: `{{route('positions')}}`,
                    columns: [
                        { data: 'id', width: '5%', render: ff.id},
                        { data: 'label', width: '25%'},
                        { data: 'users_count', width: '15%', render:(value) => `${ff.number(value)} รายการ` },
                        { data: 'created_by', width: '20%'},
                        { data: 'created_at', width: '20%', render: ff.dateandtime },
                        { data: 'action', width: '15%' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
