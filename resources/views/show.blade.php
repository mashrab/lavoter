<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="robots"                content="noindex,nofollow">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport"              content="width=device-width, initial-scale=1">

        <title>Showing your uuide</title>

        <!-- Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

        <style>
            #panel {margin-top: 50px;}
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        
        <div class="container">
            <div class="row">

                <!-- Panel -->
                <div class="panel panel-default" id="panel">

                    <!-- Panel head -->
                    <div class="panel-heading">
                        <h3 class="panel-title">Showing your uuide</h3>
                    </div><!-- /.panel-heading -->

                    <!-- Panel body -->
                    <div class="panel-body">

                        <!-- Alert block -->
                        <div class="alert alert-warning hidden">
                            The evercookie doesn't loaded...
                        </div><!-- /.alert -->

                        <!-- By PHP -->
                        <p>
                            <code id="uuide-php">{{ $uuide }}</code>
                            <b>: by PHP</b>
                        </p>

                        <!-- By the jQuery -->
                        <p>
                            <code id="uuide-jquery"></code>
                            <b>: by the jQuery</b>
                        </p>

                        <!-- By the evercookie -->
                        <p>
                            <code id="uuide-evercookie"></code>
                            <b>: by the evercookie</b>
                        </p>
                    </div><!-- /.panel-body -->

                </div><!-- /.panel -->

            </div><!-- /.row -->
        </div><!-- /.container -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!-- jQuery cookie -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- Evercookie -->
        <script src="{{ asset('vendor/lavoter/js/swfobject-2.2.min.js') }}"></script>
        <script src="{{ asset('vendor/lavoter/js/evercookie.js') }}"></script>

        <script>

            $("#uuide-jquery").text($.cookie('uuide') ? $.cookie('uuide') : 'undefined');

            /* Check evercookie is loaded */
            var evercookie = evercookie || function () {
                console.log('The evercookie doesn\'t loaded...');
                $(".alert").removeClass('hidden');
            };

            /* Evercookie initializaion */
            var ec = new evercookie({
                baseurl:  "{{ url('/') }}",
                asseturi: "/vendor/lavoter/assets",
                phpuri:   "/vendor/lavoter/php"
            });

            /* Run create/check uuide methods (detect a user) */
            ec.get('uuide', function (value) {
                if( ! value || value.toString().length <= 0) {
                    $("#uuide-evercookie").text('undefined');
                } else {
                    $("#uuide-evercookie").text(value);
                }
            });
        </script>
    </body>
</html>