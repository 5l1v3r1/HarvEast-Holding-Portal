@extends('layouts.app')
@section('content')
	<main class="home_column homeWrap">
		<div class="logoBig_wrap">
			<div class="whiteBox">
				<div class="asideNews_logo">
					<img src="/elements-img/logo/harveast-logo-big.svg" alt="Logo">
				</div>
			</div>
		</div>
		<div class="mainNews_wrap">
	    	@include('main.article')
	    	@include('main.poll')
	    	@include('main.birthdays')
	    </div>
	    <aside class="sidebar">
	    	@include('main.articles')    
	    	@include('main.info')
		</aside>
    </main>	
@endsection