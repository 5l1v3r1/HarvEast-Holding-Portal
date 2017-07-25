@extends('layouts.app')

@section('content')
    <div class="container" id="article-search" id="goTopAnc">	
        <search-article></search-article>
        <div class="goTopBtn">
			<a href="#goTopAnc">Наверх</a>
			<img class="goTopBtn_arrow" src="/elements-img/orders-svg/arrow-up.svg" alt="arrow">
		</div>
    </div>
@endsection