@extends('layouts.app')

@section('content')
<main class="orders main_column">
		<div class="main_title">
			<h1>Документы компании</h1>
		</div>
		<section class="docTabs">
			<article>
				<div class="tabs">
					@foreach($document_categories as $id => $category)
						<input id="tab{{$id+1}}" class="tabs_item" type="radio" name="tabs" @if(!$id) checked @endif >
					    <label for="tab{{$id+1}}" class="tabs_label" title="Вкладка 1">{{$category->name}}</label>
					@endforeach
					@foreach($document_categories as $id => $category)	
					    <section id="content-tab{{$id+1}}" class="tabs_content">
					        <div class="tabs_content-description">
								<ul class="tabsContent">
					        		@foreach($category->documents as $document)
										<li class="tabsContent_item"><a href="/documents/{{$document->id}}">{{$document->name}}</a></li>
									@endforeach
								</ul>
					        </div>
					    </section>
					@endforeach
				</div>
			</article>
		</section>
	</main>
@endsection