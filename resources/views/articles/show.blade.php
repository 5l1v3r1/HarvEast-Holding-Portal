@extends('layouts.app')

@section('content')
<main id="single_article" class="news_column homeWrap">
			<div class="news_wrap">

				<div class="returnBox">
					<a class="returnNews_button" href="/articles">
						<i class="fa fa-angle-double-left fa_button">
						</i>Вернутся к новостям
					</a>
					
				</div>
				<section  class="whiteBox">
					
					<article>
						<span class="sectionInfo">
							
						</span>
						<div class="allNews_title">
							<h1>{{$article->name}}</h1>
						</div>
						<div class="mainNews_content">
							{!!$article->body!!}
						</div>
						<div class="news_tags">
			           		@foreach($article->tags as $tag)
			                	<a href="/articles/?tag={{$tag->name}}" class="tags_item">{{$tag->name}}</a>
			                @endforeach
			            </div>
						<div class="comments_wrap">
						@foreach($comments['comments'] as $id => $comment)
							<div class="comment_created comment_divider first_commentDivider">
								<div class="comment_avatar">
									<img class="stuffResult_img" src="{{$comment->user->photo}}" alt="staff">
								</div>
								<div class="comment_content">
									<div class="comment_title">
										<div class="user_name"><a href="/users/{{$comment->user->id}}">{{$comment->user->name}}</a></div>
										<div class="sectionInfo">{{$comment->created_at->diffForHumans()}}</div>
									</div>
									<div class="comment_descr">
										<p>{{$comment->body}}</p>
									</div>
									<div class="comment_answer" @click="answerTo({{$comment->id}})">Ответить</div>
								</div>
							</div>
							@foreach($comments['sub_comments'][$id] as $sub_comment)
								@if($sub_comment)
									<div class="comment_created comment_divider answerComment">
									<div class="comment_avatar">
										<img class="stuffResult_img" src="{{$sub_comment->user->photo}}" alt="staff">
									</div>
									<div class="comment_content">
										<div class="comment_title">
											<div class="user_name"><a href="">{{$sub_comment->user->name}}</a></div>
											<div class="sectionInfo">{{$sub_comment->created_at->diffForHumans()}}</div>
										</div>
										<div class="comment_descr">
											<p>{{$sub_comment->body}}</p>
										</div>
										<div class="comment_answer" @click="answerTo({{$comment->id}})">Ответить</div>										
									</div>
								</div>
								@endif
							@endforeach
						@endforeach
							<div class="comment_creatingForm comment_divider">
								<div class="comment_avatar">
									<img class="stuffResult_img" src="{{$user->photo}}" alt="staff">
								</div>
								<div class="comment_content">
									<form class="comment_form" name="comment" method="post" action="/articles/{{$article->slug}}/comment">
											<input type="hidden" name="parent_id" :value="parent_id">
											{{ csrf_field() }}
											<textarea class="comment_bClick" id="comment" name="body" cols="75" rows="1" placeholder="Написать комментарий"></textarea>
											<input class="btn_addComment" type="submit" value="Отправить">
									</form>
								</div>
							</div>

						</div>
					</article>
				</section>
				<div class="returnBox">
					<a class="returnNews_button" href="/articles">
						<i class="fa fa-angle-double-left fa_button">
						</i>Вернутся к новостям
					</a>
				</div>
			</div>			
	</main>
@endsection
