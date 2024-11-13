@extends('layout')

@section('title') Политика конфиденциальности @endsection
@section('description') Политика конфиденциальности @endsection

@section('head-end')
@endsection

@section('body-end')
@endsection

@section('content')
<div class="container">
    <section class="text-content">
        <h1>Политика конфиденциальности</h1>
        {!! $tos !!}
    </section>
</div>
@endsection
