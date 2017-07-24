@php
    $bdays = App\User::todayBirthdays();
    $bmonths = App\User::monthBirthdays();
@endphp
@if($bdays->count() || $bmonths->count())
    <section class="secondaryBlock">
        <header class="headerPlace">
            <span class="secondaryBlock_title">Дни рождения</span>
        </header>
        <div class="secondaryBlock_columns">    
    	    @if($bdays->count()) 
    	        <div class="secondaryBlock_box secondaryBlock_column1 @if($bdays->count()) `Wrap @endif">
    	            <span class="birthday_title">Сегодня, {{\Jdate::now()->format('j F')}}</span>
    	            @foreach($bdays as $user)
        	            <div class="staff">
                        <div class="staffWrap_img">
                            <img class="@if($user->isHorisontalPhoto) staff_img_horizontal @else staff_img_vertical @endif" src="{{$user->photo}}" alt="staff">                        
                        </div>
        	                <div class="staff_col">
        	                    <span class="staff_name">
        							<a href="/users/{{$user->id}}" class="staff_nameLink">{{$user->name}}</a>
        						</span>
        	                </div>
        	            </div>
        	         @endforeach
    	        </div>
    	    @endif
            <div class="secondaryBlock_box secondaryBlock_column2 @if($bdays->count()) birthWrap @endif"> 
                <span class="birthday_title">Именинники месяца</span>
    			@foreach($bmonths as $user)            
    	            <div class="staff @if(!$bdays->count()) staff_noBirthday @endif">
                        <div class="staffWrap_img">
                            <img class="@if($user->isHorisontalPhoto) staff_img_horizontal @else staff_img_vertical @endif" src="{{$user->photo}}" alt="staff">                        
                        </div>
    	                <div class="staff_col">
    	                    <span class="staff_name">
    							<a href="/users/{{$user->id}}" class="staff_nameLink">{{$user->name}}</a>  
    						</span>
    	                    <span class="staff_Info">
    							{{\Jdate::parse($user->birthday)->format('j F')}}
    						</span>
    	                </div>
    	            </div>
    	        @endforeach                           
            </div>
        </div>
    </section>
@endif