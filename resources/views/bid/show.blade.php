@extends('layouts.app')

@section('content')
	{{ $bid->name }}
	<form method="POST" action="/bid/{{$bid->id}}">
		{{csrf_field()}}

		{{dd(unserialize($bid->fields))}}
		<textarea name="body" required></textarea>
		<input type="submit" name="submit">
	</form>
@endsection