@extends('layout')

@section('title')
Player History - {{ config('app.name') }}
@endsection

@section('description')
Todas las estadísticas de los jugadores que hubo en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="/js/sortable/sortable.js"></script> 
@endsection

@section('section')

<section class="normal">

<h1>Player History</h2>
  <div class="container">
    <div class="row">
      @foreach ($teams as $team)
      <div class="col playerHistoryLogo">
        <a href="{{ url('teamhistory/playerhistory', [ 'id' => $team->TeamID ]) }}"><img src="{{$team->ImgLogo}}"></a>
      </div>
      @endforeach
    </div>
  </div>

</section>

@endsection
