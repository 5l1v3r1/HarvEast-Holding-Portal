@php $poll = App\Poll::current(); @endphp
@if(isset($poll->id))
	@php
		$total = isset($poll->options) ? $poll->options->sum('votes') : 0;
	@endphp

	<section class="secondaryBlock">
        <header class="headerPlace">
            <span class="secondaryBlock_title">Опрос</span>
        </header>
        <div class="secondaryBlock_box">
	        @if(!App\User::hasVoted())
	            <form name="opros" method="post" action="/poll">
	                {{ csrf_field() }}            	
	                <span class="box_title">{{$poll->name}}:</span>
	                @foreach($poll->options as $id => $option)
	                	<div class="form_radio form_item radio_buttons">
	                		<input id="{{$id}}"type="radio" name="option" value="{{$option->id}}">
		                    <label for="{{$id}}">{{$option->name}}</label>
		                    <div class="check"></div>
	                	</div>
	                @endforeach 
	                <p class="btn_submit">
	                    <input type="submit" value="Отправить">
	                </p>
	            </form>
			@else
	            @foreach($poll->options as $option)			
		            <!-- Diagrams-Block -->
		            <div class="poll-result">
		                <span class="poll_caption">{{$option->name}}</span>
		                <div class="poll_wrap">
		                    <div class="diag">{{$option->votes}}
		                        <div style="width:{{100 * $option->votes/ $total}}%" class="diag_filled"></div>
		                    </div>
		                    <div class="diag_caption">{{100 * $option->votes/ $total}}%</div>
		                </div>
		            </div>
		        @endforeach
				<div style="color: #B4B4B4; margin: 20px 0 10px 0">{{numOfHumans($total)}}</div>
	            <!-- Diagrams-Block -->
	         @endif
    </section>
@endif
