<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            body {
                background-image: url('https://imgnooz.com/sites/default/files/wallpaper/abstract/55652/texture-wallpapers-55652-5268352.jpg');
                /* https://community.arm.com/cfs-file/__key/communityserver-blogs-components-weblogfiles/00-00-00-19-93/cybersecurity-post_2D00_1600x900.jpg */
                /* http://www.e-cellbd.com/wp-content/uploads/2016/05/wallpaper.wiki-Desktop-Cool-HD-Background-Photos-PIC-WPD0010435.jpg */
                background-size: 100% 100%;
                background-repeat: no-repeat;
                background-attachment: fixed;
                font-family: 'Nunito';
            }
        </style>

        <!-- Script -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1 mt-2 mb-2">
                    <span class="text-warning h4" style="font-weight: bolder;">URL Preview Fetcher</span>
                </div>
                <div class="col-md-8 offset-md-2 mt-1 mb-1" id="siteContent" style="display:none;">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="card-img-top img img-thumbnail" src="" height="30px" id="siteImg" alt="Website Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="card-title" id="siteTitle">This is title</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="card-text" id="siteDesc">This is Description</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 offset-md-2">
                    <!-- form action="{{ route('get-preview') }}" method="POST" -->
                        <div id="error" class="alert-danger"></div>
                        <div class="form-group">
                            <input value="" type="url" name="url" id="url" placeholder="https://" class="form-control">
                        </div>
                        <!-- @if($errors->has('url')) -->
                            <!-- {{$errors->first('url')}} -->
                        <!-- @endif -->
                        <input type="submit" id="btn" class="btn btn-danger" value="Send">
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function (){
            $('#btn').on('click', function() {
                // if ($.trim($("#url").val()) === "") {
                //     $('#error').addClass('alert');
                //     $('#error').html('Please Enter Some URL');
                //     return false;
                // } else {
                    var preview_url = $('#url').val().replace(/\/$/, '');  // .replace to remove last slash 
                    $.ajax({
                        url  : '/get-preview',
                        type : 'POST',
                        dataType : 'json',
                        data : {
                            'url'    : preview_url,
                            '_token' : '{{csrf_token()}}'
                        },
                        success : function (response) {
                            if(response.success == 'true') {
                                $('#error').removeClass('alert');
                                $('#error').html('');
                                $('#siteImg').attr('src', response.image);
                                $('#siteTitle').html(response.title);
                                $('#siteDesc').html(response.description);
                                $('#siteContent').css("display", "inline");
                                $('#siteContent').fadeIn('10000');
                            } else {
                                $('#error').addClass('alert');
                                $('#error').html(response.error_mesg.url);
                            }                            
                        }
                    });
                // }
            });
        });
    </script>
</html>
