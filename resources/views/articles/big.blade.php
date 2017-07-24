<div class="panel panel-default whity block">
  <div class="panel-body block-body">
  	{{ $article->created_at->diffForHumans() }}
    <div style="font-weight: bold;">{{$article->name}}</div>
	<div>
		{{str_limit($article->body, 1000, '...')}}
	</div>
	<a href="/articles/{{$article->slug}}">Читать дальше</a>
	<div>
		<img class="art_photo" src="{{$article->media}}"/>
	</div>		
	@foreach($article->tags as $tag)
		<span class="tag"><a href="/articles/?tag={{$tag->name}}">{{$tag->name}}</a></span>
	@endforeach
  </div>
</div>