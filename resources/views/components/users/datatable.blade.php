<section>
    <table id="users-datatable" class="display">
        <thead>
            <tr>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>สถานะ</th>
                <th>ตำแหน่ง</th>
                <th>สังกัด</th>
                <th>เพิ่มเมื่อ</th>
                <th>เครื่องมือ</th>
            </tr>
        </thead>
    </table>

    <x-slot name="scripts">
        <script src="{{asset('js/formatter.js')}}"></script>
        <script>
            $(document).ready( function () {
                $('#users-datatable').DataTable({
                    ajax: `{{route('users')}}`,
                    columns: [
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'role', render: ff.role },
                        { data: 'id' }, // TODO:: POSITION
                        { data: 'id' }, // TODO:: AFFILIATION
                        { data: 'created_at', render: ff.dateandtime },
                        { data: 'action' },
                    ]
                });
            } );
        </script>
    </x-slot>
</section>
