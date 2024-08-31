<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('users.heading') }}
            </h2>

            <x-button
                variant="primary"
                class="items-center max-w-xs gap-2"
            >
                <x-heroicon-o-plus class="w-6 h-6" aria-hidden="true" />

                <span>เพิ่มผู้ใช้</span>
            </x-button>
        </div>
    </x-slot>

    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>Column 1</th>
                <th>Column 2</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Row 1 Data 1</td>
                <td>Row 1 Data 2</td>
            </tr>
            <tr>
                <td>Row 2 Data 1</td>
                <td>Row 2 Data 2</td>
            </tr>
        </tbody>
    </table>

    <x-slot name="scripts">
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>
    </x-slot>
</x-app-layout>
