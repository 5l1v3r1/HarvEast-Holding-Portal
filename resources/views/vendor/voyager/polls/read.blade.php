@extends('voyager::master')

@section('page_header')
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"> 

    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> Viewing {{ ucfirst($dataType->display_name_singular) }}
    </h1>
@stop

@section('content')
    @php
        $total = isset($dataTypeContent->options) ? $dataTypeContent->options->sum('votes') : 0;
    @endphp

    <section class="secondaryBlock">
        <header class="headerPlace">
            <span class="secondaryBlock_title">Опрос {{$dataTypeContent->name}}</span>
        </header>
        <div class="secondaryBlock_box">            
        @foreach($dataTypeContent->options as $option)         
            <div class="poll-result">
                <span class="poll_caption">{{$option->name}}</span>
                <div class="poll_wrap">
                    <div class="diag">{{$option->votes}}
                        <div @if($total) style="width:{{100 * $option->votes/ $total}}%" @endif class="diag_filled"></div>
                    </div>
                    <div class="diag_caption">@if($total) {{100 * $option->votes/ $total}}% @endif</div>
                </div>
            </div>
        @endforeach
        <div style="color: #B4B4B4; margin: 20px 0 10px 0">{{numOfHumans($total)}}</div>
    </section>
    @foreach($dataTypeContent->options as $option)
    <span class="poll_caption">{{$option->name}}</span>
        @foreach($option->users as $user)
            <a href="/users/{[$user->id}}">{{$user->name}}</a>
        @endforeach
    <hr>
    @endforeach
@stop

@section('javascript')
@stop
