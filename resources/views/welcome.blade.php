@extends('layout')

@section('title')
Index Page - {{ config('app.name') }}
@endsection

@section('description')
Página principal de la liga {{ config('app.name') }}.
@endsection


@section('section')

<section class="normal">

<h1>Welcome to {{ config('app.name') }}!</h1>

<div class="embed-youtube">
  <iframe src="https://www.youtube-nocookie.com/embed/t1vaembXXRE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

</section>

@endsection


