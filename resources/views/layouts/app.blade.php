<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>HarvEast</title> 
	    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-theme.min.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"> 
    </head>
	<body style="background-image:url(/storage/app/public/background.jpg); ">
		<div class="wrapper">
		    @include('components.nav')
			<div class="content">	            
		        @yield('content')
			</div>
			<div class="footer">
				<div class="copyright main_column">
					<div class="copyright_item">
						<span @if(!Storage::disk('public')->exists('background.jpg')) style="color:black !important;" @endif class="copyright_descr">2017 © HarvEast Holding</span>
					</div>
				</div>

				<div @if(!Storage::disk('public')->exists('background.jpg')) style="overflow:hidden;height:80px;background:url('/elements-img/patterns/optimised.svg') 0 -30px repeat-x;background-size:auto 794px" @endif class="footer_green">
				</div>	
			</div> <!-- footer -->
		</div>
		<script src="{{ asset('js/app.js')}}"></script>
	</body>
</html>