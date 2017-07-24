@if($article = App\Article::anchored())
	<section class="mainNews whiteBox">
        <article>
            <span class="sectionInfo">
				Главная новость
			</span>
            <div class="mainNews_title">
                <h1><a href="/articles/{{$article->slug}}">{{$article->name}}</a></h1>
            </div>
            <div class="mainNews_content">
               {!!str_limit(mediaLess($article->body), 1000, '...')!!}
            </div>
            <div class="readMore">
                <a class="readMore_button" href="/articles/{{$article->slug}}">Читать дальше</a>
            </div>
            @if($article->media)
	            <div class="mainNews_photo">
	            	{!!$article->media!!}
	            </div>
	        @endif
            <div class="news_tags">
           		@foreach($article->tags as $tag)
                	<a href="/articles/?tag={{$tag->name}}" class="tags_item">{{$tag->name}}</a>
                @endforeach
            </div>
        </article>
    </section>
@endif