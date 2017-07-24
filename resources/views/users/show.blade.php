@extends('layouts.app')

@section('content')
	<main class="main_column homeWrap">
		<div style="max-width: 60%" class="mainNews_wrap">
			<section class="mainNews userBox">
				<div class="user_card">
					<div class="userfoto">
						<img class="userfoto_img" src="{{$user->photo}}" alt="user_foto">
					</div>
					<div class="user_info">
						<div class="user_title">
							<h1>{{ $user->name }}</h1>
						</div>
						<div class="user_content">
							<span class="user_post">{{ isset($user->position) ? $user->position->name : ''}}</span>
							<span class="user_departament">{{ isset($user->department) ? $user->department->name : ''}}</span><br>
							<div class="user_contacts">
								<div class="contacts_descr">Контакты:</div>
								<div class="contacts_descr">
									<p>{{ $user->city->name }}</p>
									<p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
									@if($user->phones->count())
										@foreach($user->phones as $phone)
						                   <p>{{ $phone->phone }}</p>
						                @endforeach
						            @endif
								</div>
								
							</div>
							@if(isset($user->birthday))
							<div class="user_contacts">
								<div class="contacts_descr">Дополнительно:</div>
								<div class="contacts_descr">
									<p>День рождения {{ Jdate::parse($user->birthday)->format('j F') }}</p>					
								</div>
							</div>
							@endif
						</div>
						
					</div>
				</div>
			</section>
		</div>
		<aside class="sidebar"> <!-- sidebar -->
		@if(isset($user->department))
		<div class="asideBox">	
			<section class="secondaryBlock">
				<header class="headerPlace">
					<span class="secondaryBlock_title">{{ $user->department->name }}</span>	
				</header>
				@foreach($user->coworkers() as $user)
					<div class="secondaryBlock_box">
						<div class="userSidebar">
							<div class="staffWrap_img">	
								<img class="@if($user->IsHorizontalPhoto) staff_img_horizontal @else staff_img_vertical @endif" src="{{$user->photo}}" alt="staff">
							</div>
							<div class="userSidebar_col">	
								<div class="userSidebar_title">
									<a href="/users/{{$user->id}}">{{ $user->name }}</a>
								</div>
								<div class="userSidebar_content">
									<span class="userSidebar_post">{{ isset($user->position) ? $user->position->name : ''}}</span>
									<span class="userSidebar_departament">{{ $user->department->name}}</span>
									<div class="userSidebar_contacts">
										<div class="contacts_descr">
											<p>{{ $user->city->name}}</p>
											<p><a href="mailto:{{ $user->email}}">{{ $user->email}}</a></p>
							                @if($user->phones->count())
												@foreach($user->phones as $phone)
								                   <p>{{ $phone->phone }}</p>
								                @endforeach
								            @endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class="divider"></div>
				@endforeach
			</section>
		</aside > <!-- sidebar -->
		@endif
	</main>			                
@endsection