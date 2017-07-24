<link rel="stylesheet" type="text/css" href="{{asset('css/mail.css')}}"> 

@component('mail::message')
# Introduction
Ваша учетная запись успешно создана. <br>
Данные для хода в <a href="{{config('app.url')}}">{{config('app.url')}}</a>:

Логин - {{ $user->email }}
Пароль - {{ $password }}

Крайне рекомендуем изменить пароль.

С уважением,<br>
{{ config('app.name') }}
@endcomponent
