@component('mail::message')

{{auth()->user()->name}} ответил на комментарий к новости: 
{{$comment->body}}

@component('mail::button', ['url' => $url])
Перейти к новости
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent
