@extends('layouts.app')

@section('content')
	<main id="userb" class="orders main_column">
		<div class="main_title">
			<h1>Оставить заявку</h1>
		</div>
			<section class="order">
			@foreach(App\BidCategory::all() as $category)
				<article class="order_article">
					<header class="header_name">
						<h2>{{$category->name}}</h2>
					</header>
					<div class="orders_column">
						<div class="column">
							@foreach($category->bids->where('published', 1)->all() as $bid)
								<div class="order_item">
									<bid-modal :name="'{{$bid->name}}'" :fields="'{{$bid->fields}}'" {{':csrf="'.csrf_token().'"' }} :id="{{$bid->id}}" >
										{{ $bid->name }}
									</bid-modal>
								</div>
							@endforeach
						</div>
					</div>
				</article>
			@endforeach
		</section>

		@if (session('status'))
			<div v-if="showSuccess" class="orderForm_wrap">
			<section  class="successForm orderForm">
				<div @click="showSuccess = !showSuccess" class="close_icon"></div>
				<article class="successForm_content">
					<header class="successForm_header">
						<h2>Ваша заявка принята</h2>
					</header>
					<span class="successForm_descr">Менеджер свяжется с вами, ожидайте звонок.</span>
				</article>
			</section>
			</div>
		@endif

	</main>
@endsection