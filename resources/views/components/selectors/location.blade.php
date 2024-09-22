<script>
    const createLocationSelector = () => {
        $('.location-selector').select2({
            ajax: {
                url: @js(route('locations.selectize')),
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.label,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    }

    $(document).ready(createLocationSelector);
</script>
