<?php $info = App\Info::current() ?>
@if(isset($info))
	<section class="secondaryBlock">
	    <header class="headerPlace">
	        <span class="secondaryBlock_title">{{ $info->name }}</span>
	    </header>
	    <div class="secondaryBlock_box">
	        {{ $info->body }}
	        <div class="secondaryNews_photo">
	        	<img style="width:100%" src="{{$info->photo}}">
	        </div>
	    </div>	    
	</section>
@endif