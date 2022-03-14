@extends('layout')

@section('title')
Web Search - {{ config('app.name') }}
@endsection

@section('description')
Buscador de {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">
  <h1>Web Search</h1>
  @if(sizeof($players) > 0)
  <h2 class="search">Showing player search results "{{$id}}"</h2>
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
  @endif

  @if(sizeof($coaches) > 0)
  <h2 class="search">Showing coach search results "{{$id}}"</h2>
  <div class="playerSearch">
    @foreach ($coaches as $coach)     
    <div class="card mb-3">
        <div class="row g-0">
          <div class="col-md-4">
            <img class="img-fluid rounded-start" src="{{$coach['PlayerPhoto']}}"
            onerror="this.onerror=null; this.src='/images/nonplayers/default.png';">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              @if ($coach['CoachURL'] <> "N/A")
              <h5 class="card-title"><a href="{{$coach['CoachURL']}}">{{$coach['Full_Name']}}</a></h5>
              @else
              <h5 class="card-title">{{$coach['Full_Name']}}</a></h5>
              @endif
              <h6 class="card-subtitle mb-2 text-muted">
                  @if ($coach['TeamID'] > 0)
                  <img src="{{$coach['ImgLogo']}}" width="24" />
                  @endif
                  @if ($coach['Team'] <> "N/A")
                  {{$coach['Team']}} 
                  @endif
              </h6>
              <ul class="card-text">
                  <li>{{$coach['Wins']}} Career wins</li>
                  <li>{{$coach['Losses']}} Career losses</li>
                  <li>{{$coach['Championships']}} Championships</li>
              </ul>
            </div>
          </div>
        </div>
    </div>
    @endforeach
  </div>
  @endif
</section>

@endsection


