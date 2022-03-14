@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/sortable/sortable.js"></script>
<script src="/js/teamStats.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
<script>

  @include('js/changeURL')

  function changeTeam(){
      @if ($team->TeamID < 32)
      window.location.href = "{{ url('teamstats', [ 'id' => $team->affiliate()->TeamID ]) }}";
      @else
      window.location.href = "{{ url('teamstats', [ 'id' => $team->parentTeam()->TeamID ]) }}";
      @endif
    }

  function changeTable(value){

    var stats = $("#Stats :selected").val(); 
    var time = $("#Time :selected").val(); 

    if (stats == 1){

      if(time == 2){

        showBasic36();

      } else if(time == 3){

        showBasicTotal();

      } else{

        showBasic();

      }

    } else {

      if (stats == 2){

        showShooting();

      } else {

        if (stats == 3){

          if (time == 2){

            showAdvanced36();

          } else {

            showAdvanced();

          }

        } else {

          if(time == 3){

            showMiscellaneousTotal();

          } else {

            showMiscellaneous();

          }    

        }
          
      }
    }    
  }

</script>

@endsection

@section('section')

<section>

@include('html.team_top')
<h2 id="h2Staff">Team Stats</h2>
<div class="container">
  <div class="row">
    <div class="col-sm">
      <select onchange="changeTeam();" class="form-select" aria-label="Team Options">
        <option selected disabled hidden>Team Options</option>
        @if ($team->TeamID < 32)
        <option>View {{$team->affiliate()->TeamName}} Roster (G-LG Affiliate)</option>
        @else
        <option>View {{$team->parentTeam()->TeamName}} Roster (Parent Team)</option>
        @endif
      </select>
    </div>
    <div class="col-sm">
      <select onchange="changeTable();" class="form-select" aria-label="Select Stats" id="Stats">
        <option disabled>STAT CATEGORIES</option>
        <option disabled>───────────────</option>
        <option value="1">Basic Stats</option>
        <option value="2">Shooting Stats</option>
        <option value="3">Advanced Stats</option>
        <option value="4">Miscellaneous Stats</option>
      </select>
    </div>
    <div class="col-sm">
      <select onchange="changeTable();" class="form-select" aria-label="Select Time" id="Time">
        <option disabled>STAT TIME FRAMES</option>
        <option disabled>───────────────</option>
        <option selected value="1">Per Game</option>
        <option value="2">Per 36 minutes</option>
        <option value="3">Stat Totals</option>
      </select>
    </div>
    <div class="col-sm">
      <select class="form-select" aria-label="Stats Key" id="statsKey">
        <option disabled selected>Stats Key</option>
        <option disabled>───────────────</option>
        <option disabled>BASIC STATS</option>
        <option disabled>───────────────</option>
        <option>3PM - 3 Pointers Made</option>
        <option>3PA - 3 Pointers Attempted</option>
        <option>3P% - 3 Point Percentage</option>
        <option>FTM - Free Throws Made</option>
        <option>FTA - Free Throws Attempted</option>
        <option>FT% - Free Throw Percentage</option>
        <option>ORB - Offensive Rebounds</option>
        <option>DRB - Defensive Rebounds</option>
        <option>TRB - Total Rebounds</option>
        <option>AST - Assists</option>
        <option>STL - Steals</option>
        <option>BLK - Blocks</option>
        <option>TOV - Turnovers</option>
        <option>PF - Personal Fouls</option>
        <option>PTS - Points</option>
        <option disabled>───────────────</option>
        <option disabled>SHOOTING STATS</option>
        <option disabled>───────────────</option>
        <option>2PA - Percent of shots as 2 pointers</option>
        <option>0-3A - Percent of shots within 3 feet</option>
        <option>3-10A - Percent of shots from 3-10 feet</option>
        <option>10-16A - Percent of shots from 10-16 feet</option>
        <option>16-3PA - Percent of shots from 16 feet to 3 point line</option>
        <option>3PA - Percent of shots as 3 pointers</option>
        <option>2P% - Field Goal Percentage from 2 point range</option>
        <option>0-3% - Field Goal Percentage within 3 feet</option>
        <option>3-10% - Field Goal Percentage from 3-10 feet</option>
        <option>10-16% - Field Goal Percentage from 10-16 feet</option>
        <option>16-3P% - Field Goal Percentage from 16 feet to 3 point line</option>
        <option>3P% - Field Goal Percentage from 3 point range</option>
        <option disabled>───────────────</option>
        <option disabled>ADVANCED STATS</option>
        <option disabled>───────────────</option>
        <option>ON - +/- While on court </option>
        <option>OFF - +/- While off court </option>
        <option>NET - Net +/- </option>
        <option>PER - Player Efficiency Rating </option>
        <option>TS% - True Shooting Percentage</option>
        <option>EFG% - Effective Field Goal Percentage</option>
        <option>ORB% - Offensive Rebound Percentage</option>
        <option>DRB% - Defensive Rebound Percentage</option>
        <option>TRB% - Total Rebound Percentage</option>
        <option>AST% - Assist Percentage</option>
        <option>STL% - Steal Percentage</option>
        <option>BLK% - Block Percentage</option>
        <option>TO% - Turnover Percentage</option>
        <option>A/TO - Assist to Turnover Ratio</option>
        <option>USG% - Usage Percentage</option>
        <option disabled>───────────────</option>
        <option disabled>MISCELLANEOUS STATS</option>
        <option disabled>───────────────</option>
        <option>DRVS - Drives Stopped</option>
        <option>DRVF - Drives Faced</option>
        <option>STP% - Percentage of drives stopped</option>
        <option>TOFC - Turnovers Forced</option>
        <option>PTAL - Points Allowed</option>
        <option>SHTF - Shots Faced</option>
        <option>PA/SF - Points Allowed per Shots Faced</option>
        <option>TCHS - Touches</option>
        <option>TO/TCH - Turnovers per Touches</option>
        <option>A/TCH - Assists per Touches</option>
        <option>CHRG - Charges Taken</option>
        <option>TECH - Technical Fouls</option>
      </select>
    </div>
  </div>
</div>

<div class="table-responsive normal">

  <table class="table sortable" id="teamBasic">
    <thead class="thead">
      <tr>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">GP</th>
          <th scope="col">GS</th>
          <th scope="col">MIN</th>
          <th scope="col">FGM</th>
          <th scope="col">FGA</th>
          <th scope="col">FG%</th>
          <th scope="col">3PM</th>
          <th scope="col">3PA</th>
          <th scope="col">3P%</th>
          <th scope="col">FTM</th>
          <th scope="col">FTA</th>
          <th scope="col">FT%</th>
          <th scope="col">ORB</th>
          <th scope="col">DRB</th>
          <th scope="col">TRB</th>
          <th scope="col">AST</th>
          <th scope="col">STL</th>
          <th scope="col">BLK</th>
          <th scope="col">TOV</th>
          <th scope="col">PF</th>
          <th scope="col">PTS</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->getBasicArray() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$team->getUrlPlayertoHTML(
            $team->checkPlayer($player['Player']))}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['GP']}}</td>
          <td>{{$player['GS']}}</td>
          <td>{{$player['MIN']}}</td>
          <td>{{$player['FGM']}}</td>
          <td>{{$player['FGA']}}</td>
          <td>{{$player['FG%']}}</td>
          <td>{{$player['3PM']}}</td>
          <td>{{$player['3PA']}}</td>
          <td>{{$player['3P%']}}</td>
          <td>{{$player['FTM']}}</td>
          <td>{{$player['FTA']}}</td>
          <td>{{$player['FT%']}}</td>
          <td>{{$player['ORB']}}</td>
          <td>{{$player['DRB']}}</td>
          <td>{{$player['TRB']}}</td>
          <td>{{$player['AST']}}</td>
          <td>{{$player['STL']}}</td>
          <td>{{$player['BLK']}}</td>
          <td>{{$player['TOV']}}</td>
          <td>{{$player['PF']}}</td>
          <td>{{$player['PTS']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamShooting">
    <thead class="thead">
      <tr>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">2PA</th>
          <th scope="col">0-3A</th>
          <th scope="col">3-10A</th>
          <th scope="col">10-16A</th>
          <th scope="col">16-3PA</th>
          <th scope="col">3PA</th>
          <th scope="col">2P%</th>
          <th scope="col">0-3%</th>
          <th scope="col">3-10%</th>
          <th scope="col">10-16%</th>
          <th scope="col">16-3P%</th>
          <th scope="col">3P%</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->getShootingArray() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$team->getUrlPlayertoHTML(
            $team->checkPlayer($player['Player']))}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['2PA']}}</td>
          <td>{{$player['0-3A']}}</td>
          <td>{{$player['3-10A']}}</td>
          <td>{{$player['10-16A']}}</td>
          <td>{{$player['16-3PA']}}</td>
          <td>{{$player['3PA']}}</td>
          <td>{{$player['2P%']}}</td>
          <td>{{$player['0-3%']}}</td>
          <td>{{$player['3-10%']}}</td>
          <td>{{$player['10-16%']}}</td>
          <td>{{$player['16-3P%']}}</td>
          <td>{{$player['3P%']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamAdvanced">
    <thead class="thead">
        <tr>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">ON</th>
          <th scope="col">OFF</th>
          <th scope="col">NET</th>
          <th scope="col">PER</th>
          <th scope="col">TS%</th>
          <th scope="col">EFG%</th>
          <th scope="col">ORB%</th>
          <th scope="col">DRB%</th>
          <th scope="col">TRB%</th>
          <th scope="col">AST%</th>
          <th scope="col">STL%</th>
          <th scope="col">BLK%</th>
          <th scope="col">TO%</th>
          <th scope="col">A/TO</th>
          <th scope="col">USG%</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->getAdvancedArray() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$team->getUrlPlayertoHTML(
            $team->checkPlayer($player['Player']))}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['ON']}}</td>
          <td>{{$player['OFF']}}</td>
          <td>{{$player['NET']}}</td>
          <td>{{$player['PER']}}</td>
          <td>{{$player['TS%']}}</td>
          <td>{{$player['EFG%']}}</td>
          <td>{{$player['ORB%']}}</td>
          <td>{{$player['DRB%']}}</td>
          <td>{{$player['TRB%']}}</td>
          <td>{{$player['AST%']}}</td>
          <td>{{$player['STL%']}}</td>
          <td>{{$player['BLK%']}}</td>
          <td>{{$player['TO%']}}</td>
          <td>{{$player['A/TO']}}</td>
          <td>{{$player['USG%']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamMiscellaneous">
    <thead class="thead">
      <tr>
        <th scope="col">POS</th>
        <th scope="col">PLAYER</th>
        <th scope="col">DRVS</th>
        <th scope="col">DRVF</th>
        <th scope="col">STP%</th>
        <th scope="col">TOFC</th>
        <th scope="col">PTAL</th>
        <th scope="col">SHTF</th>
        <th scope="col">PA/SF</th>
        <th scope="col">TCHS</th>
        <th scope="col">TO/TCH</th>
        <th scope="col">A/TCH</th>
        <th scope="col">CHRG</th>
        <th scope="col">TECH</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->getMiscellaneousArray() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$team->getUrlPlayertoHTML(
            $team->checkPlayer($player['Player']))}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['DRVS']}}</td>
          <td>{{$player['DRVF']}}</td>
          <td>{{$player['STP%']}}</td>
          <td>{{$player['TOFC']}}</td>
          <td>{{$player['PTAL']}}</td>
          <td>{{$player['SHTF']}}</td>
          <td>{{$player['PA/SF']}}</td>
          <td>{{$player['TCHS']}}</td>
          <td>{{$player['TO/TCH']}}</td>
          <td>{{$player['A/TCH']}}</td>
          <td>{{$player['CHRG']}}</td>
          <td>{{$player['TECH']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamBasicTotal">
    <thead class="thead">
      <tr>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">GP</th>
          <th scope="col">GS</th>
          <th scope="col">MIN</th>
          <th scope="col">FGM</th>
          <th scope="col">FGA</th>
          <th scope="col">FG%</th>
          <th scope="col">3PM</th>
          <th scope="col">3PA</th>
          <th scope="col">3P%</th>
          <th scope="col">FTM</th>
          <th scope="col">FTA</th>
          <th scope="col">FT%</th>
          <th scope="col">ORB</th>
          <th scope="col">DRB</th>
          <th scope="col">TRB</th>
          <th scope="col">AST</th>
          <th scope="col">STL</th>
          <th scope="col">BLK</th>
          <th scope="col">TOV</th>
          <th scope="col">PF</th>
          <th scope="col">PTS</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->searchResultBasicTotal() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$player['URL']}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['GP']}}</td>
          <td>{{$player['GS']}}</td>
          <td>{{$player['MIN']}}</td>
          <td>{{$player['FGM']}}</td>
          <td>{{$player['FGA']}}</td>
          <td>{{$player['FG%']}}</td>
          <td>{{$player['3PM']}}</td>
          <td>{{$player['3PA']}}</td>
          <td>{{$player['3P%']}}</td>
          <td>{{$player['FTM']}}</td>
          <td>{{$player['FTA']}}</td>
          <td>{{$player['FT%']}}</td>
          <td>{{$player['ORB']}}</td>
          <td>{{$player['DRB']}}</td>
          <td>{{$player['TRB']}}</td>
          <td>{{$player['AST']}}</td>
          <td>{{$player['STL']}}</td>
          <td>{{$player['BLK']}}</td>
          <td>{{$player['TOV']}}</td>
          <td>{{$player['PF']}}</td>
          <td>{{$player['PTS']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamBasic36">
    <thead class="thead">
      <tr>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">GP</th>
          <th scope="col">GS</th>
          <th scope="col">MIN</th>
          <th scope="col">FGM</th>
          <th scope="col">FGA</th>
          <th scope="col">FG%</th>
          <th scope="col">3PM</th>
          <th scope="col">3PA</th>
          <th scope="col">3P%</th>
          <th scope="col">FTM</th>
          <th scope="col">FTA</th>
          <th scope="col">FT%</th>
          <th scope="col">ORB</th>
          <th scope="col">DRB</th>
          <th scope="col">TRB</th>
          <th scope="col">AST</th>
          <th scope="col">STL</th>
          <th scope="col">BLK</th>
          <th scope="col">TOV</th>
          <th scope="col">PF</th>
          <th scope="col">PTS</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->searchResultBasic36() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$player['URL']}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['GP']}}</td>
          <td>{{$player['GS']}}</td>
          <td>{{$player['MIN']}}</td>
          <td>{{$player['FGM']}}</td>
          <td>{{$player['FGA']}}</td>
          <td>{{$player['FG%']}}</td>
          <td>{{$player['3PM']}}</td>
          <td>{{$player['3PA']}}</td>
          <td>{{$player['3P%']}}</td>
          <td>{{$player['FTM']}}</td>
          <td>{{$player['FTA']}}</td>
          <td>{{$player['FT%']}}</td>
          <td>{{$player['ORB']}}</td>
          <td>{{$player['DRB']}}</td>
          <td>{{$player['TRB']}}</td>
          <td>{{$player['AST']}}</td>
          <td>{{$player['STL']}}</td>
          <td>{{$player['BLK']}}</td>
          <td>{{$player['TOV']}}</td>
          <td>{{$player['PF']}}</td>
          <td>{{$player['PTS']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamAdvanced36">
    <thead class="thead">
      <tr>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">ON</th>
          <th scope="col">OFF</th>
          <th scope="col">NET</th>
          <th scope="col">PER</th>
          <th scope="col">TS%</th>
          <th scope="col">EFG%</th>
          <th scope="col">ORB%</th>
          <th scope="col">DRB%</th>
          <th scope="col">TRB%</th>
          <th scope="col">AST%</th>
          <th scope="col">STL%</th>
          <th scope="col">BLK%</th>
          <th scope="col">TO%</th>
          <th scope="col">A/TO</th>
          <th scope="col">USG%</th>
      </tr>
    </thead>
    <tbody>
      @foreach($team->searchResultAdvanced36() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$team->getUrlPlayertoHTML(
            $team->checkPlayer($player['Player']))}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['ON']}}</td>
          <td>{{$player['OFF']}}</td>
          <td>{{$player['NET']}}</td>
          <td>{{$player['PER']}}</td>
          <td>{{$player['TS%']}}</td>
          <td>{{$player['EFG%']}}</td>
          <td>{{$player['ORB%']}}</td>
          <td>{{$player['DRB%']}}</td>
          <td>{{$player['TRB%']}}</td>
          <td>{{$player['AST%']}}</td>
          <td>{{$player['STL%']}}</td>
          <td>{{$player['BLK%']}}</td>
          <td>{{$player['TO%']}}</td>
          <td>{{$player['A/TO']}}</td>
          <td>{{$player['USG%']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamMiscellaneousTotal">
    <thead class="thead">
      <tr>
        <th scope="col">POS</th>
        <th scope="col">PLAYER</th>
        <th scope="col">DRVS</th>
        <th scope="col">DRVF</th>
        <th scope="col">STP%</th>
        <th scope="col">TOFC</th>
        <th scope="col">PTAL</th>
        <th scope="col">SHTF</th>
        <th scope="col">PA/SF</th>
        <th scope="col">TCHS</th>
        <th scope="col">TO/TCH</th>
        <th scope="col">A/TCH</th>
        <th scope="col">CHRG</th>
        <th scope="col">TECH</th>
      </tr>
  </thead>
    <tbody>
      @foreach($team->searchResultMiscellaneousTotal() as $player)
      <tr>
        <td>{{$player['Pos']}}</th>
          <th scope="row"><a href="{{$team->getUrlPlayertoHTML(
            $team->checkPlayer($player['Player']))}}" >
            {{$player['Player']}}</a></th>
          <td>{{$player['DRVS']}}</td>
          <td>{{$player['DRVF']}}</td>
          <td>{{$player['STP%']}}</td>
          <td>{{$player['TOFC']}}</td>
          <td>{{$player['PTAL']}}</td>
          <td>{{$player['SHTF']}}</td>
          <td>{{$player['PA/SF']}}</td>
          <td>{{$player['TCHS']}}</td>
          <td>{{$player['TO/TCH']}}</td>
          <td>{{$player['A/TCH']}}</td>
          <td>{{$player['CHRG']}}</td>
          <td>{{$player['TECH']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div>

<script>

  $('table.table.sortable').stickyTableHeaders();

</script>

</section>

@endsection