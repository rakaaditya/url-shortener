@extends('layout')

@section('title', 'URL Shortener')

@section('top_css')
<style>
    body {
      padding-top: 70px;
      padding-bottom: 20px;
      background: #ebebeb;
    }
    .navbar-inverse {
        background: #35303F !important;
        border: none !important;
    }
    .top-container {
        /*padding: 20px;*/
        margin: 10px 30px;
    }
    .timer-container {
        color: #fff;
        text-align: right;
        padding: 10px;
    }
    .logo {
        color: #fff;
        text-align: left;
        padding: 10px;
    }
    #shorturl {
        font-size: 28px;
    }
</style>
@endsection

@section('content')
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="top-container">
    <div class="col-lg-6 logo">
      <img src="http://cdn-ck.gedrix.net/assets/img/logo_gedrix.png" width="100">
    </div>
  </div>
</nav>

<div class="container" style="margin-top: 10%;">
    <div class="alert alert-danger" style="display: none;" id="status_info">
        <button type="button" class="close">&times;</button>
        <div id="message"></div>
    </div>
    <div id="form-container" style="text-align: center;">
        <form method="post" id="short_form">
            <input name="long_url" class="form-control" placeholder="URL: http://www.domain.com" id="long_url">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <br/>
            <button type="submit" class="btn btn-default" id="shorten">Shorten</button>
        </form>
    </div>
    <div id="shorturl-container" style="text-align: center; display: none;">
        <div id="shorturl"></div>
        <button class="btn btn-primary" id="short-btn"><i class="fa fa-copy"></i> Copy</button>
    </div>
</div> <!-- /container -->
@endsection

@section('bottom_js')
<script type="text/javascript" src="//cdn-ck.gedrix.net/assets/vendor/zclip/jquery.zclip.js"></script>
<script>
$(document).ready(function() {
    $('#short_form').submit(function(event) {
        $('#shorten').attr('disabled','disabled').html('Please Wait...');
        $.ajax({
            type: "POST",
            url: "{{url()}}",
            data: $('#short_form').serialize(),
            success: function(data)
            {
                $('#long_url').val('');
                if(data.status == 'failed') {
                    $('#status_info').show();
                    $('#message').empty().html(data.error.long_url);
                } else {
                    $('#form-container').hide();
                    $('#shorturl-container').show();
                    $('#shorturl').html(data.short_url);
                    $('#short-btn').zclip({
                        path: '//cdn-ck.gedrix.net/assets/vendor/zclip/ZeroClipboard.swf',
                        copy: data.short_url,
                        afterCopy: function() {
                            $('#short-btn').attr('disabled','disabled').html('Copied!').delay(800).queue(function() {
                                $(this).dequeue();
                            });
                        }
                    });
                }
                $('#shorten').removeAttr('disabled').html('Shorten');
                setTimeout(function(){ 
                    $('#status_info').fadeOut('slow');
                }, 3000);
            }
        });
        event.preventDefault();
    });
    $('.close').click(function() {
        $('#status_info').hide();
    });
});
</script>
@endsection
