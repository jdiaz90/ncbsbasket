@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script>

  @include('js/changeURL')

</script>   
@endsection

@section('section')

<section>

@include('html.team_top')
<h2 id="h2Staff">Team Insights</h2>
<div class="container teamInsights normal">
  <div class="row">
    <div class="col">
      <span>{{$team['PPG']}}</span><br/>
      POINTS PER GAME ({{$positions['PPG']}})
    </div>
    <div class="col">
      <span>{{$team['APG']}}</span><br/>
      ASSISTS PER GAME ({{$positions['APG']}})
    </div>
    <div class="col">
      <span>{{$team['RPG']}}</span><br/>
      REBOUNDS PER GAME ({{$positions['RPG']}})
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['PPG']['Logo']}}" /><span>{{$leaders['PPG']['Value']}}</span><br/>
      POINTS PER GAME LEADER
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['APG']['Logo']}}" /><span>{{$leaders['APG']['Value']}}</span><br/>
      ASSISTS PER GAME LEADER
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['RPG']['Logo']}}" /><span>{{$leaders['RPG']['Value']}}</span><br/>
      REBOUNDS PER GAME LEADER
    </div>
  </div>
  <div class="row">
    <div class="col">
      <span>{{$team['OPPG']}}</span><br/>
      POINTS ALLOW PER GAME ({{$positions['OPPG']}})
    </div>
    <div class="col">
      <span><span>{{$team['BPG']}}</span></span><br/>
      BLOCKS PER GAME ({{$positions['BPG']}})
    </div>
    <div class="col">
      <span><span>{{$team['SPG']}}</span></span><br/>
      STEALS PER GAME ({{$positions['SPG']}})
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['OPPG']['Logo']}}" /><span>{{$leaders['OPPG']['Value']}}</span><br/>
      POINTS ALLOW PER GAME LEADER
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['BPG']['Logo']}}" /><span>{{$leaders['BPG']['Value']}}</span><br/>
      BLOCKS PER GAME LEADER
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['SPG']['Logo']}}" /><span>{{$leaders['SPG']['Value']}}</span><br/>
      STEALS PER  GAME LEADER
    </div>
  </div>
  <div class="row">
    <div class="col">
      <span><span>{{$team['FGPct']}}</span></span><br/>
      FIELD GOALD PERCENTAGE ({{$positions['FGPct']}})
    </div>
    <div class="col">
      <span>{{$team['FG3PPct']}}</span><br/>
      THREE POINT PERCENTAGE ({{$positions['FG3PPct']}})
    </div>
    <div class="col">
      <span>{{$team['FTPct']}}</span><br/>
      FREE THROW PERCENTAGE ({{$positions['FTPct']}})
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['FGPct']['Logo']}}" /><span>{{$leaders['FGPct']['Value']}}</span><br/>
     FIELD GOAL PERCENTAGE LEADER 
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['FG3PPct']['Logo']}}" /><span>{{$leaders['FG3PPct']['Value']}}</span><br/>
      THREE POINT PERCENTAGE LEADER
    </div>
    <div class="col">
      <img width="48" src="{{$leaders['FTPct']['Logo']}}" /><span>{{$leaders['FTPct']['Value']}}</span><br/>
      FREE THROW PERCENTAGE LEADER
    </div>
  </div>
  <!--<div class="row">
    <div class="col">
      <span></span><br/>
      OFFENSIVE RATING
    </div>
    <div class="col">
      <span></span><br/>
      DEFENSIVE RATING
    </div>
    <div class="col">
      <span></span><br/>
      NET RATING
    </div>
    <div class="col">
      <span></span><br/>
      OFFENSIVE RATING LEADER
    </div>
    <div class="col">
      <span></span><br/>
      DEFENSIVE RATING LEADER
    </div>
    <div class="col">
      <span></span><br/>
      NET RATING LEADER
    </div>
  </div> -->
  
</div>

</section>

@endsection
