@component('mail::message')
У вас новая заявка “{{$name}}”<br>
Отправитель: <a href="{{config('app.url').'/users/'.$user->id}}">{{$user->name}}</a>

@component('mail::table')
|               |            |
| - | -|
@foreach($data as $field)
| {{isset($field['label']) ? $field['label'] : '-' }}    | {{ (!is_array($field['value']) && isset($field['value'])) ? $field['value'] : '-'}}|
@endforeach
@endcomponent
С благодарностью,<br>
{{ $user->name }}
@endcomponent
