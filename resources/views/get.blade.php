<script src="{{ asset('vendor/lavoter/fingerprint2/fingerprint2.min.js') }}"></script>
<script>

    /**
     * The fingerprintjs2 init
     */
    var uuid;
    
    $(document).ready(function ()
    {
        new Fingerprint2().get(function(result, components)
        {
            uuid = result;

            // Run the check method.
            uuidCheckOrCreate(uuid);
        });
    });

    /**
     * Check uuid
     */
    function uuidCheckOrCreate (uuid) {
        $.ajax({
            url: '{{ route("lavoter.check_or_create") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                uuid: uuid
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