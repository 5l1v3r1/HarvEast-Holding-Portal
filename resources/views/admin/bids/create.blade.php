@extends('voyager::master')

@section('content')
	<div id="crebid" class="crebidclass">
	  	<form action="/admin/bids" method="POST" enctype="multipart/form-data">
	  		{{ csrf_field() }}
			<div class="col-md-6 statusblock1">
					<p>Ответственный менэджер:</p>
					<select name="responsible_id" class="formtypeselect">
					@foreach(App\Role::bidResponsibles() as $responsible)
			    		<option value="{{$responsible->id}}"> {{ $responsible->display_name }}</option>
			    	@endforeach
				</select>	
			</div>
			<bid-form></bid-form>
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
	</style>
	<script src="{{asset('js/app.js')}}"></script>
@endsection

