@extends('voyager::master')

@section('content')
	<div  id="crebid" class="crebidclass whiteBox_square">
		
	  	<form action="/admin/bids/{{$bid->id}}" method="POST" enctype="multipart/form-data">
	  		
	  		{{ csrf_field() }}
            {{ method_field("PUT") }}

			<div class="statusblock1">
				<h2>Редактировать заявку</h2>
				<input type="text" class="form-control" name="name" value="{{$bid->name}}" required>
				<p>Ответственный менэджер:</p>
				<select name="responsible_id" class="formtypeselect">
					@foreach(App\Role::bidResponsibles() as $responsible)
			    		<option value="{{$responsible->id}}" @if($responsible->id == $bid->responsible_id) selected @endif> {{ $responsible->display_name }}</option>
			    	@endforeach
				</select>	
			</div>
			<div style="flex-wrap: wrap">
				<div class="statusblock1">
					<p>Выбрать категорию заявки:</p>
					<select name="category_id" class="formtypeselect">
						@foreach($categories as $category)
							<option value="{{$category->id}}"> {{ $category->name }} </option>
						@endforeach	
					</select>
				</div>
				<div class="statusblock1">
					<p>Статус заявки:</p>
					<input id="published" type="checkbox" name="published" checked>
					<label for="published">Опубликовано</label> 	
				</div>
			</div>
			<div class="publish-block"><input type="submit" class="publish-form" name="submit" placeholder="Опубликовать заявку"></div>
		</form>

	</div>		
	<style lang="css" scoped>
			.formtypeselect {
				margin: 0;
				border: 2px solid #e4eaec;
				border-radius: 5px;
				padding: 0.3rem;
				width: 50%;
			}
			.statusblock1 {
				max-width: 700px;
				padding: 1rem 4rem;
			}
			.crebidclass {
				padding:2rem;
			}
			.publish-form {
				display: block;
				margin: 0 auto;
				text-align: center;
				padding: 0.5rem 1rem;
				background-color: #16b43b;
				color: #fff;
				border: 2px solid #16b43b;
			}
			@media screen and (max-width:767px) {
				.crebidclass {
					padding:0;
				}
				.statusblock1 {
					padding: 1rem 1rem;
				}
			}
			.fle {
				display:flex;
				justify-content:space-between;
				flex-direction: column;
			}
	</style>
	<script src="{{asset('js/app.js')}}"></script>
@endsection

