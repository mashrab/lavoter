<script src="{{ asset('vendor/lavoter/js/swfobject-2.2.min.js') }}"></script>
<script src="{{ asset('vendor/lavoter/js/evercookie.js') }}"></script>
<script>
    
    function uuideCreate (ec) {
        $.post('/lavoter/uuide-create', {}, function (response) {
            if (response.status == 'success' && response.length == response.uuide.length) {
                ec.set('uuide', response.uuide);

                window.UUIDE =  response.uuide;
            } else {
                console.log('Lavoter: something went wrong.')
            }
        }).fail(function () {
            console.log('A POST request has been failed (Lavoter: uuideCreate).');
        });
    }

    function uuideCheck (ec, uuide) {
        $.post('/lavoter/uuide-check/' + uuide, {}, function (response) {
            if (response.status == 'success' && response.length == response.uuide.length) {
                ec.set('uuide', response.uuide);

                window.UUIDE = response.uuide;
            } else {
                console.log('Lavoter: something went wrong.')
            }
        }).fail(function () {
            console.log('A POST request has been failed (Lavoter: uuideCheck).');
        });
    }

    var evercookie = evercookie || function(){console.log('The evercookie doen\'t loaded...')};

    var ec = new evercookie({
        baseurl:  "{{ url('/') }}",
        asseturi: "/vendor/lavoter/assets",
        phpuri:   "/vendor/lavoter/php"
    });

    ec.get('uuide', function (value) {
        if( ! value || value.toString().length <= 0) {
            uuideCreate(ec);
        } else {
            uuideCheck(ec, value);
        }

        $(document).trigger('evercookie.load');
    });

</script>