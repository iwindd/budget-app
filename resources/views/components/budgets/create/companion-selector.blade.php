<section>
    <select class="companion-selector w-full outline-none" name="companions[]" multiple="multiple"></select>

    <x-slot name="scripts">
        <script src="{{ asset('js/formatter.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.companion-selector').select2({
                    ajax: {
                        url: @js(route('users.companions')),
                        dataType: 'json',
                        delay: 250,
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    console.log(item);

                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
            });
        </script>
    </x-slot>
</section>
