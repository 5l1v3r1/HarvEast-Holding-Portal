@php
	$articles = App\Article::relevant(5);
@endphp
@if($articles->count())
<div class="asideBox">
	@foreach($articles as $article)
	<article class="aside_section">
		<span class="sectionInfo">
			{{ $article->created_at->diffForHumans() }}
		</span>
		<div class="secondaryNews">
		    <a class="secondaryNews_title" href="/articles/{{$article->slug}}"><h2>{{$article->name}}</h2></a>
		</div>
		<div class="secondaryNews_content">
		    <p>{{ str_limit(strip_tags($article->body), 160, '...') }}</p>
		</div>
		<div class="readMore">
		    <a class="readMoreS_button"href="/articles/{{$article->slug}}">Читать дальше</a>
		</div>
		<div class="news_tags">
			@foreach($article->tags as $tag)
		    	<a class="tags_item" href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a>
			@endforeach
		</div>
	</article>
	<div class="divider"></div>
	@endforeach
	<article class="aside_section">
        <div class="readNews">
            <a class="readNews_button" href="/articles">Все новости</a>
        </div>
    </article>
</div>
@endif