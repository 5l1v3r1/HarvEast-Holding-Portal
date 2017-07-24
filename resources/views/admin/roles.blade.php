@extends('voyager::master')

@section('content')
<br>
<div class="col-md-12">
	<div class="container panel panel-bordered">
		<div class="panel-body table-responsive">
			<form action="{{ $url }}" method="POST"> 
				{{csrf_field()}}
				<input type="hidden" name="role" value="{{$role->id}}">
				<div class="row col-md-12">
					@foreach(App\City::all() as $city)
					<div class="row col-md-12">
						<div class="col-md-2">
							<div class="dataTables_length">
								<label>{{$city->name}}</label>
							</div>
						</div>
						<div class="col-md-10">
							<div class="dataTables_length">
							@foreach(App\Department::all() as $department)
								<div class="dataTables_length" style="display:flex;">
									<p>{{$department->name}}</p>
									<select class="form-control select2" style="width:250px" name="head[{{$city->id}}][{{$department->id}}]">
											<option value="">&nbsp;</option>						
										@foreach($users->where('city_id', $city->id)->where('department_id', $department->id)->all() as $user)
											<option value="{{$user->id}}" @if($user->isRole($role->id)) selected @endif>{{$user->name}}</option>
										@endforeach
									</select>
									<input class="form-control input-sm" type="email" style="max-width:300px;" name="email[{{$city->id}}][{{$department->id}}]" 
									@if($email = App\RoleDepartmentsEmail::exists($city->id, $department->id, $role->id)) 
										value="{{$email}}"
									@endif>
								</div>
								<br>
							@endforeach
							</div>
						</div>
					<hr>
					</div>	
					@endforeach
				</div>
				<input type="submit" class="btn btn-success" name="submit">
			</form>
		</div>	
	</div>	
</div>	
@endsection