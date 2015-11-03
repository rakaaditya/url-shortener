@extends('layout')

@section('title', 'Redirecting')

@section('top_css')
<style>
    body {
      padding-top: 50px;
      padding-bottom: 20px;
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
</style>
@endsection

@section('bottom_js')
<script type="text/javascript" src="//cdn-ck.gedrix.net/assets/js/jquery.plugin.js"></script> 
<script type="text/javascript" src="//cdn-ck.gedrix.net/assets/js/jquery.countdown.js"></script>
<script>
    $(document).ready(function(){
        $('#counter').countdown({until: 5, format: 'S', expiryUrl: '{{$url}}', layout: '{sn}',
            onTick: highlightLast5});

        function highlightLast5(periods) {
            if ($.countdown.periodsToSeconds(periods) === 2) {
                $(this).addClass('highlight');
            }
        }
    });
</script>
@endsection

@section('content')
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="top-container">
    <div class="col-lg-6 logo">
      <img src="http://cdn-ck.gedrix.net/assets/img/logo_gedrix.png" width="100">
    </div>
    <div class="col-lg-6 timer-container">
        Redirecting in <span id="counter"></span>
    </div><!--/.navbar-collapse -->
  </div>
</nav>

<div class="container">
    @include('ads')
</div> <!-- /container -->
@endsection
