
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="shdev">

        <title>Laravel Update App</title>

        {{-- <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/floating-labels/"> --}}

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="https://getbootstrap.com/docs/4.4/examples/floating-labels/floating-labels.css" rel="stylesheet">
    </head>

    <body>
        <div class="form-signin" id="form">
            <div class="text-center mb-4">
                <img class="mb-4" src="https://laravel.com/img/favicon/apple-touch-icon.png" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Laravel Update App</h1>
                <p>This page is to update your application, you must be careful when updating</p>
            </div>

            <div class="form-label-group">
                <input type="text" class="form-control" placeholder="{{ $lastversion }}" value="{{ $lastversion }}" disabled>
                <label for="last">Last Version Can Be Install:</label>
            </div>

            <div class="form-label-group">
                <input type="text" id="your" class="form-control" placeholder="{{ $localversion }}" value="{{ $localversion }}" disabled>
                <label for="your">You Version : </label>
            </div>

            <div class="checkbox mb-3">
                <label>
                <input type="checkbox" id="maintenance-mode" value="true" @if(config('update.maintenance-mode') == 'true') {{ 'disabled' }} @endif checked> Turn on maintenance mode ( it's recommended )
                </label>
            </div>

            <div class="alert alert-success" style="display: none" id="alert-success" role="alert">
                ...
            </div>

            <button class="btn btn-lg btn-primary btn-block" id="startUpdate" type="button">
                <span id="start-btn-text">Start Update</span>
                <span class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true" style="display: none"></span>
                <span style="display: none" class="spinner">Loading...</span>
            </button>

            <p class="mt-5 mb-3 text-muted text-center">&copy; 2021-2022</p>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
        $(document).ready(function(){

            $('#startUpdate').click(function(){
                
                console.log('is clicked')
                // AJAX request
                $.ajax({
                url: '{{ route("updater.start") }}/'+$('#maintenance-mode').prop('checked'),
                type: 'get',
                // data: {userid: userid},
                beforeSend: function () {
                    $('#start-btn-text').css('display','none');
                    $('.form-label-group').css('display','none');
                    $('#startUpdate').prop('disabled', true);
                    $('.spinner').css('display','block');
                    $('#alert-success').css('display','none');
                },
                success: function(response){ 
                        console.log(response)
                        $('#start-btn-text').css('display','block');
                        $('.form-label-group').css('display','block');
                        $('#startUpdate').prop('disabled', false);
                        $('.spinner').css('display','none');
                        $('#alert-success').css('display','block');
                        $('.alert').text(response.message)
                    }
                });
            });
        });
        </script>
    </body>
</html>
