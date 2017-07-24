@extends('layouts.app')

@section('content')
	<main class="main_column documentWrap">
		<div class="documentPrtSc">
			<img class="documentPrtSc_item" src="@if(isset($document->photo)) /storage/app/public/{{$document->photo }} @else /public/elements-img/documents/example.png @endif" alt="example">
		</div>
		<section class="documentInfo whiteBox documentBox">
			<article>
				<div class="documentInfo_title">
					<h1>{{ $document->name }}</h1>
				</div>
				<div class="documentInfo_descr">
					<p>{{ $document->description }}</p>
				</div>
				<div class="documentInfo_download">
					
					<p class="btn_download">
						<a href="/storage/app/public/{{ $document->link }}" > 
							Cкачать
						</a>
						<span>
							.{{$extension}}
						</span>
					</p>
					
				</div>
			</article>
		</section>
	</main>
@endsection