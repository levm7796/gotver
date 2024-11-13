@extends('layout')

@section('title') Правила пользования платформой @endsection
@section('description') Правила пользования платформой @endsection
@section('head-end')
@endsection

@section('body-end')
@endsection

@section('content')
<div class="container">
    <section class="text-content">
        <h1>Правила пользования платформой</h1>
        {!! $tac !!}
    </section>
</div>
@endsection
