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
<script src="/js/teamAwards.js"></script> 
@endsection

@section('section')

<section>

@include('html.team_top')
<h2 id="h2Staff">Team Information</h2>
<div class="teamInfo0 normal">
  <div class="teamInfo1">
    
    <div class="owner">
      <div class="container">
        <h3>Owner Information</h3>
        <div class="row">
          <div class="col-sm">
            <img src="/images/owners/{{str_replace(" ","_", $team->OwnerName)}}.png" 
            onerror="this.onerror=null; this.src='/images/owners/default.jpg';" />
          </div>
          <div class="col-sm ownerName">
            {{$team->OwnerName}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <div class="progress">
              <div class="progress-bar progress-bar-striped {{$ownerInfo['SpendColor']}} progress-bar-animated" role="progressbar" aria-valuenow="{{$ownerInfo['Spend']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$ownerInfo['Spend']}}%"></div>
            </div>
            Willingness To Spend
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
          <div class="progress">
            <div class="progress-bar progress-bar-striped {{$ownerInfo['WinColor']}} progress-bar-animated" role="progressbar" aria-valuenow="{{$ownerInfo['Win']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$ownerInfo['Win']}}%"></div>
          </div>
          Desire To Win
        </div>
        </div>
        <div class="row">
          <div class="col-sm">
          <div class="progress">
            <div class="progress-bar progress-bar-striped {{$ownerInfo['PatienceColor']}} progress-bar-animated" role="progressbar" aria-valuenow="{{$ownerInfo['PatienceColor']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$ownerInfo['Patience']}}%"></div>
          </div>
          Patience Level
        </div>
        </div>
        <div class="row">
          <div class="col-sm">
          <div class="progress">
            <div class="progress-bar progress-bar-striped {{$ownerInfo['StarColor']}} progress-bar-animated" role="progressbar" aria-valuenow="{{$ownerInfo['Star']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$ownerInfo['Star']}}%"></div>
          </div>
          Desire For Superstars
        </div>
        </div>
      </div>
    </div>

    <div class="teamHistory">
      <div class="container">
        <h3>Team History</h3>
        <div class="row">
          <div class="col-sm">
            <span>{{$team->TeamWins}} - {{$team->TeamLosses}}</span><br/>
            ALL-TIME RECORD
          </div>
          <div class="col-sm">
            <span>{{round($team->TeamWins / ($team->TeamWins + $team->TeamLosses), 3)}}</span><br/>
            WINNING PERCENTAGE
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <span>{{$team->TeamPlayoffs}}</span><br/>
            PLAYOFF APPEARANCES
          </div>
          <div class="col-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-trophy-fill" viewBox="0 0 16 16">
              <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z"/>
            </svg><span>{{$team->TeamChampionships}}</span><br/>
            CHAMPIONSHIPS
          </div>
        </div>
      </div>
    </div>

    <div class="championships">
      <div class="container">
        <h3>Championships Seasons</h3>
        <div class="row">
          <div class="col-sm">
        @foreach ($team->champions as $champion)
            <span>{{$champion->SeasonID}}</span>
        @endforeach
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="teamInfo2">

    <div class="teamInformation">
      <div class="container">
        <h3>Team Information</h3>
        <div class="row">
          <div class="col-sm">
            <span>City</span> {{$team->CityName}}
          </div>
          <div class="col-sm">
            <span>Abbreviation</span> {{$team->TeamAbbrev}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <span>Team Name</span> {{$team->TeamName}}
          </div>
          <div class="col-sm">
            <span>Fan Support</span> {{$team->FanSupport}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <span>Arena Built</span> {{$team->YearBuilt}}
          </div>
          <div class="col-sm">
            <span>Arena Capacity</span> {{$team->Capacity}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <span>Arena Name</span> {{$team->Arena}}
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <span>Affiliate Team</span> {{$team->affiliate()->Franchise}}
          </div>
        </div>
      </div>
    </div>

    <div class="teamGraphs">
      <div class="container">
        <h3>Team Graphics</h3>
        <div class="row">
          <div class="col-sm">
            Team Logo<br/>
            <img width="80" src="{{$team->ImgLogo}}" />
          </div>
          <div class="col-sm">
            Team Court<br/>
            <img width="150" src="{{$team->Court}}" />
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            Home Jersey<br/>
            <img width="50" src="{{$team->HomeJersey}}" />
          </div>
          <div class="col-sm">
            Road Jersey<br/>
            <img width="50" src="{{$team->AwayJersey}}" />
          </div>
          <div class="col-sm">
            Alternate Jersey<br/>
            <img width="50" src="{{$team->AltJersey}}" />
          </div>
        </div>
        <div class="row">
          <div class="col-sm colors">
            Primary Color
            <canvas id="myCanvas" width="50" height="50">
              Your browser does not support the HTML5 canvas tag.</canvas>
              
              <script>
              var c = document.getElementById("myCanvas");
              var ctx = c.getContext("2d");
              ctx.beginPath();
              ctx.arc(25, 25, 24, 0, 2 * Math.PI);
              ctx.fillStyle = "<?php print($team->PrimeColor); ?>";
              ctx.fill();
              ctx.stroke();
              </script> 
          </div>
          <div class="col-sm colors">
            Secondary Color
            <canvas id="myCanvas2" width="50" height="50">
              Your browser does not support the HTML5 canvas tag.</canvas>
              
              <script>
              var c = document.getElementById("myCanvas2");
              var ctx = c.getContext("2d");
              ctx.beginPath();
              ctx.arc(25, 25, 24, 0, 2 * Math.PI);
              ctx.fillStyle = "<?php print($team->SecondColor); ?>";
              ctx.fill();
              ctx.stroke();
              </script> 
          </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="teamInfo3">

    <div class="retired">
      <div class="container">
        <h3>Retired Numbers</h3>
        <div class="row">
          <div class="col-sm">
            @foreach ($team->retiredJerseys as $retired)
                <span class="retired">{{$retired->JerseyNumber}}</span>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="retired">
      <div class="container">
        <h3>Team Awards</h3>
        <div class="row">
          <div class="col-sm">
            <select onchange="changeTable(this.value)" class="form-select" name="teamAwards" aria-label="Default team awards">
              <option value="1">Most Valuable Player</option>
              <option value="2">Defensive Player of the Year</option>
              <option value="3">Rookie of the Year</option>
              <option value="4">Sixth Man of the Year</option>
              <option value="5">Coach of the Year</option>
              <option value="6">All-League 1st Team</option>
              <option value="7">All-League 2nd Team</option>
              <option value="8">All-League 3rd Team</option>
              <option value="9">All-Defense 1st Team</option>
              <option value="10">All-Defense 2nd Team</option>
              <option value="11">All-Rookie 1st Team</option>
              <option value="12">All-Rookie 2nd Team</option>
            </select>
            <img id="awardPhoto" src="/images/trophies/mvp.png" />
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            @include('function/teamAwards')
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</section>

@endsection
