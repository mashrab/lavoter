<script src="{{ asset('vendor/lavoter/fingerprint2/fingerprint2.min.js') }}"></script>
<script>

    /**
     * The fingerprintjs2 init
     */
    var lavoter_uuid;
    
    $(document).ready(function ()
    {
        new Fingerprint2().get(function(result, components)
        {
            lavoter_uuid = result;

            // Run the check method.
            uuidCheckOrCreate(lavoter_uuid);
        });
    });

    /**
     * Check lavoter_uuid
     */
    function uuidCheckOrCreate (lavoter_uuid) {
        $.ajax({
            url: '{{ route("lavoter.check_or_create") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                lavoter_uuid: lavoter_uuid
            },
            dataType: 'json'
        })
        .success(function (response) {
            console.log('Lavoter: you are successfully identified');
        })
        .fail(function (response) {
            console.log('Lavoter: a POST request has been failed');
        });
    }

</script>