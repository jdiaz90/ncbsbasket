@extends('layout')

@section('title')
{{$seasonPrev->team->Franchise}} Season Preview Guide- {{ config('app.name') }}
@endsection

@section('description')
Vista previa de la temporada {{ config('app.name') }}.
@endsection

@section('css')

<style type="text/css">

.projectedPlayers{
  background: url('{{$seasonPrev->team->ImgCourt}}'); 
  background-position: center -60px; 
  background-repeat: no-repeat; 
  background-size: cover;
}

.projected { 
    width: 100%;
    color: white;
    background-color: {{$seasonPrev->team->TeamColor}};
}

.playerTitle{ 
    width: 190px;
    color: white;
    background-color: {{$seasonPrev->team->TeamColor}};
}

#keyBench{
  color: white;
  background-color: {{$seasonPrev->team->TeamColor}};
}

.seasonPrevInfo1{
    color: white;
    background: linear-gradient(180deg, {{$seasonPrev->team->TeamColor}} 0%, rgba(0,0,0,1) 100%);
}

@media (max-width: 1085px) {

  .projectedPlayers{
      background-image: none;
  }

}

</style>

@endsection

@section('javascript')

<script type="text/javascript">

function previousTeam(){
  window.location.href = "{{ url('seasonprev', [ 'id' => $previous->team->TeamID ]) }}";
}

function nextTeam(){
  window.location.href = "{{ url('seasonprev', [ 'id' => $next->team->TeamID ]) }}";
}

function conferenceEast(){
  window.location.href = "{{ url('seasonprev', [ 'id' => 31 ]) }}";
}

function conferenceWest(){
  window.location.href = "{{ url('seasonprev', [ 'id' => 32 ]) }}";
}

</script>

@endsection

@section('section')

<section class="normal" id="seasonPrev">
<h1>Season Preview Guide - {{$seasonPrev->team->Franchise}}</h1>
  <div class="container seasonPrevButtons">
    <div class="row">
      <div class="col">
        @if ($seasonPrev->ConfID == 1)
        <button type="button" class="btn btn-secondary seasonPrev" id="westernButton" onclick="conferenceWest();">View Western Conference</button>
        @else
        <button type="button" class="btn btn-secondary seasonPrev" id="easternButton" onclick="conferenceEast();">View East Conference</button> 
        @endif
      </div>
      <div class="col">
        <button type="button" class="btn btn-secondary seasonPrev" onclick="previousTeam();">Previous Team</button>
      </div>
      <div class="col">
        <button type="button" class="btn btn-secondary seasonPrev" onclick="nextTeam();">Next Team</button>
      </div>
    </div>
  </div>

  <div class="seasonPrevTitle">
    <img width="100" src="{{$seasonPrev->ConferenceLogo}}">
    <h2>Eastern Conference</h2>
    <div class="seasonPrevTeams">
      @foreach ($standings as $item)
          <a href="{{ url('seasonprev', [ 'id' => $item->team->TeamID ]) }}"><img width="48" src="{{$item->team->ImgLogo}}"></a>
      @endforeach
    </div>
  </div>

  <div class="seasonPrevInfo">
    <div class="divTable">
      <table class="seasonPrevInfo1">
        <tr>
          <th><h3 class="h3Center">{{$seasonPrev->team->Franchise}}</h3></th>
        </tr>
        <tr>
          <td>Head Coach: {{$seasonPrev->coach->Full_Name}}</td>
        </tr>
        <tr>
          <td>Division Rank: #{{$seasonPrev->DivRank}}</td>
        </tr>
        <tr>
          <td>Conference Rank: #{{$seasonPrev->ConfRank}}</td>
        </tr>
        <tr>
          <td>{{$maxSeason}}-{{$maxSeason + 1}} Record: {{$seasonPrev->Wins}}-{{$seasonPrev->Losses}}</td>
        </tr>
        <tr>
          <td>Points Scored (Rank): {{$seasonPrev->PtsScored}} ({{$seasonPrev->PtsScoredRank}})</td>
        </tr>
        <tr>
          <td>Points Allowed (Rank): {{$seasonPrev->PtsAllowed}} ({{$seasonPrev->PtsAllowedRank}})</td>
        </tr>
      </table>
    </div>
  
    <div class="divTable">
      <table class="seasonPrevInfo2 keyBenchColor">
        <tr>
          <th><h3 id="keyBench">Key Bench Players</h3></th>
        </tr>
        <tr>
          <td>{{$seasonPrev->player6->Full_Name}} ({{$seasonPrev->player6->AbPosition}}) -
            {{roundSeasonPrev($seasonPrev->PPG6)}} PPG /
            {{roundSeasonPrev($seasonPrev->APG6)}} APG /
            {{roundSeasonPrev($seasonPrev->RPG6)}} RPG</td>
        </tr>
        <tr>
          <td>{{$seasonPrev->player7->Full_Name}} ({{$seasonPrev->player7->AbPosition}}) -
            {{roundSeasonPrev($seasonPrev->PPG7)}} PPG /
            {{roundSeasonPrev($seasonPrev->APG7)}} APG /
            {{roundSeasonPrev($seasonPrev->RPG7)}} RPG</td>
        </tr>
        <tr>
          <td>{{$seasonPrev->player8->Full_Name}} ({{$seasonPrev->player6->AbPosition}}) -
            {{roundSeasonPrev($seasonPrev->PPG8)}} PPG /
            {{roundSeasonPrev($seasonPrev->APG8)}} APG /
            {{roundSeasonPrev($seasonPrev->RPG8)}} RPG</td>
        </tr>
        <tr>
          <td>{{$seasonPrev->player9->Full_Name}} ({{$seasonPrev->player6->AbPosition}}) -
            {{roundSeasonPrev($seasonPrev->PPG9)}} PPG /
            {{roundSeasonPrev($seasonPrev->APG9)}} APG /
            {{roundSeasonPrev($seasonPrev->RPG9)}} RPG
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="court">

    <div class="projected">
      <h3>2022-2023 Projected Starters</h3>
    </div>

    <div class="projectedPlayers">

      <div class="projectedP5">
        <div>
          <span>C</span>
          <img class="playerCourt" src="{{$seasonPrev->player5->PlayerPhoto}}" onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="playerSP">
          <div class="playerTitle">
            {{$seasonPrev->player5->Full_Name}}
          </div>
          <div class="white">
            {{roundSeasonPrev($seasonPrev->PPG5)}} PPG / 
            {{roundSeasonPrev($seasonPrev->APG5)}} APG / 
            {{roundSeasonPrev($seasonPrev->RPG5)}} RPG
          </div>
        </div>
      </div>

      <div class="projectedP4">
        <div>
          <span>PF</span>
          <img class="playerCourt" src="{{$seasonPrev->player4->PlayerPhoto}}" onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="playerSP">
          <div class="playerTitle">
            {{$seasonPrev->player4->Full_Name}}
          </div>
          <div class="white">
            {{roundSeasonPrev($seasonPrev->PPG4)}} PPG / 
            {{roundSeasonPrev($seasonPrev->APG4)}} APG / 
            {{roundSeasonPrev($seasonPrev->RPG4)}} RPG
          </div>
        </div>
      </div>

      <div class="projectedP3">
        <div>
          <span>SF</span>
          <img class="playerCourt" src="{{$seasonPrev->player3->PlayerPhoto}}" onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="playerSP">
          <div class="playerTitle">
            {{$seasonPrev->player3->Full_Name}}
          </div>
          <div class="white">
            {{roundSeasonPrev($seasonPrev->PPG3)}} PPG / 
            {{roundSeasonPrev($seasonPrev->APG3)}} APG / 
            {{roundSeasonPrev($seasonPrev->RPG3)}} RPG
          </div>
        </div>
      </div>

      <div class="projectedP2">
        <div>
          <span>SG</span>
          <img class="playerCourt" src="{{$seasonPrev->player2->PlayerPhoto}}" onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="playerSP">
          <div class="playerTitle">
            {{$seasonPrev->player2->Full_Name}}
          </div>
          <div class="white">
            {{roundSeasonPrev($seasonPrev->PPG2)}} PPG / 
            {{roundSeasonPrev($seasonPrev->APG2)}} APG / 
            {{roundSeasonPrev($seasonPrev->RPG2)}} RPG
          </div>
        </div>
      </div>

      <div class="projectedP1">
        <div>
          <span>PG</span>
          <img class="playerCourt" src="{{$seasonPrev->player1->PlayerPhoto}}" onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="playerSP">
          <div class="playerTitle">
            {{$seasonPrev->player1->Full_Name}}
          </div>
          <div class="white">
            {{roundSeasonPrev($seasonPrev->PPG1)}} PPG / 
            {{roundSeasonPrev($seasonPrev->APG1)}} APG / 
            {{roundSeasonPrev($seasonPrev->RPG1)}} RPG
          </div>
        </div>
      </div>

    </div>

  </div>

</section>

@endsection


