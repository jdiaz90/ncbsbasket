@extends('layout')

@section('title')
Player Search - {{ config('app.name') }}
@endsection

@section('description')
Buscador de la liga {{ config('app.name') }}.
@endsection

@section('section')
<section class="normal">
  <h1>Player Search</h1>
  <h2 class="search">Showing search results "{{$id}}"</h2>
  <div class="playerSearch">
    @foreach ($players as $player)     
    <div class="card mb-3">
      <div class="row g-0">
        <div class="col-md-4">
          <img class="img-fluid rounded-start" src="{{$player['PlayerPhoto']}}"
          onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title"><a href="{{$player['PlayerURL']}}">{{$player['Full_Name']}}</a></h5>
            <h6 class="card-subtitle mb-2 text-muted">
              @if ($player['Position'] <> "N/A")
              #{{$player['JerseyNum']}} - {{$player['Position']}}<br/>    
              @endif
              @if ($player['TeamID'] > 0)
              <img src="{{$player['ImgLogo']}}" width="24" />
              @endif
              {{$player['Team']}}
            </h6>
            <ul class="card-text">
              <li>{{round($player['PPG'], 1)}} points per game</li>
              <li>{{round($player['APG'], 1)}} assists per game</li>
              <li>{{round($player['RPG'], 1)}} rebounds per game</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

@endsection
