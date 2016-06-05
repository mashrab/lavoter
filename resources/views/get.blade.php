<script src="{{ asset('vendor/lavoter/js/swfobject-2.2.min.js') }}"></script>
<script src="{{ asset('vendor/lavoter/js/evercookie.js') }}"></script>
<script>
    
    /* Create uuide (uuid evercookie) */
    function uuideCreate (ec) {
        $.ajax({
            url: '{{ route("lavoter.create") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json'
        })
        .success(function (response) {
            if (response.status == 'success' && response.length == response.uuide.length) {
                ec.set('uuide', response.uuide);
                window.UUIDE = response.uuide;
            } else {
                console.log('Lavoter: something went wrong.')
            }
        })
        .fail(function (response) {
            console.log('A POST request has been failed (Lavoter: uuideCreate).');
        });
    }

    /* Check uuide (uuid evercookie) */
    function uuideCheck (ec, uuide) {
        $.ajax({
            url: '{{ route("lavoter.check") }}' + '/' + uuide,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json'
        })
        .success(function (response) {
            if (response.status == 'success' && response.length == response.uuide.length) {
                ec.set('uuide', response.uuide);

                window.UUIDE = response.uuide;
            } else {
                console.log('Lavoter: something went wrong.')
            }
        })
        .fail(function (response) {
            console.log('A POST request has been failed (Lavoter: uuideCheck).');
        });
    }

    /* Check evercookie is loaded */
    var evercookie = evercookie || function () {
        console.log('The evercookie doesn\'t loaded...');
    };

    /* Evercookie initialization */
    var ec = new evercookie({
        baseurl:  "{{ url('/') }}",
        asseturi: "/vendor/lavoter/assets",
        phpuri:   "/vendor/lavoter/php"
    });

    /* Run create/check uuide methods (detect an user) */
    ec.get('uuide', function (value) {
        if( ! value || value.toString().length <= 0)
            uuideCreate(ec);
        else
            uuideCheck(ec, value);

        $(document).trigger('evercookie.load');
    });

</script>