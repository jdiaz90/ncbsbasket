@extends('layout')

@include('html.player_top')
<div class="container mr-2" role="group" aria-label="Player Options">
    <div class="row">
      <div class="col-md">
        <button type="button" onclick="changeURL(1);" class="btn btn-secondary active">Player Bio</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(2);" class="btn btn-secondary">Player Profile</button>
      </div>
      <div class="col-md">
        <button type="button" class="btn btn-secondary active disabled">Player Stats</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(4);" class="btn btn-secondary">Game Logs</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(5);" class="btn btn-secondary">Staff Report</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(6);" class="btn btn-secondary">Ratings Progression</button>
      </div>
    </div>
</div>

<div class="bottom_pro">

    <div class="container mr-2" role="group" aria-label="Player Options">
        <div class="row">
        @if((sizeof($player->Stats) + sizeof($player->StatsThisSeason)) > 0)
          <div class="col-md">
            <button type="button" onclick="showStatistics();" 
            class="btn btn-secondary margin disabled active"
            id="statisticsButton">Regular Season</button>
          </div>
        @endif
        @if(sizeof($player->PlayoffStats) > 0)
          <div class="col-md">
            <button type="button" onclick="showPlayoffStats();" 
            class="btn btn-secondary margin" 
            id="playoffStatsButton">Playoffs</button>
          </div>
        @endif
        </div>
    </div>

    <div class="overflow-auto" id="statistics">

    @if((sizeof($player->Stats) + sizeof($player->StatsThisSeason)) > 0)
        <table class="table oneline">
            <thead class="thead">
                <tr>
                    <th scope="col">Season</th>
                    <th scope="col">Team</th>
                    <th scope="col">G</th>
                    <th scope="col">GS</th>
                    <th scope="col">MPG</th>
                    <th scope="col">PPG</th>
                    <th scope="col">APG</th>
                    <th scope="col">RPG</th>
                    <th scope="col">DRPG</th>
                    <th scope="col">ORPG</th>
                    <th scope="col">SPG</th>
                    <th scope="col">BPG</th>
                    <th scope="col">TOPG</th>
                    <th scope="col">Points</th>
                    <th scope="col">FGM</th>
                    <th scope="col">FGA</th>
                    <th scope="col">FG%</th>
                    <th scope="col">FTM</th>
                    <th scope="col">FTA</th>
                    <th scope="col">FT%</th>
                    <th scope="col">3PM</th>
                    <th scope="col">3PA</th>
                    <th scope="col">3P%</th>
                    <th scope="col">Assists</th>
                    <th scope="col">DRebs</th>
                    <th scope="col">ORebs</th>
                    <th scope="col">Rebounds</th>
                    <th scope="col">Steals</th>
                    <th scope="col">Blocks</th>
                    <th scope="col">TOs</th>
                    <th scope="col">DQ</th>
                    <th scope="col">PER</th>
                    <th scope="col">TS%</th>
                    <th scope="col">EFF</th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                @foreach($player->StatsThisSeason as $stats)
                <th scope="row">{{$player->CurrentSeason}}</th> 
                    @if($stats->SeasonID == "PBL Season")
                <th scope="row">PBL Season</th>
                    @else
                <th scope="row">DBL Season</th>
                    @endif
                <td>{{$stats->G}}</td>
                <td>{{$stats->GS}}</td>
                <td>{{round($stats->MPG, 1)}}</td>
                <td>{{round($stats->PPG, 1)}}</td>
                <td>{{round($stats->APG, 1)}}</td>
                <td>{{round($stats->RPG, 1)}}</td>
                <td>{{round($stats->DRPG, 1)}}</td>
                <td>{{round($stats->ORPG, 1)}}</td>
                <td>{{round($stats->SPG, 1)}}</td>
                <td>{{round($stats->BPG, 1)}}</td>
                <td>{{round($stats->TOPG, 1)}}</td>
                <td>{{$stats->Points}}</td>
                <td>{{$stats->FGM}}</td>
                <td>{{$stats->FGA}}</td>
                <td>,{{$stats->FGP}}</td>
                <td>{{$stats->FTM}}</td>
                <td>{{$stats->FTA}}</td>
                <td>,{{$stats->FTP}}</td>
                <td>{{$stats->FG3PM}}</td>
                <td>{{$stats->FG3PA}}</td>
                <td>,{{$stats->FG3PP}}</td>
                <td>{{round($stats->Assists, 1)}}</td>
                <td>{{round($stats->DRebs, 1)}}</td>
                <td>{{round($stats->ORebs, 1)}}</td>
                <td>{{round($stats->Rebounds, 1)}}</td>
                <td>{{round($stats->Steals, 1)}}</td>
                <td>{{round($stats->Blocks, 1)}}</td>
                <td>{{round($stats->Turnovers, 1)}}</td>
                <td>{{round($stats->DQ, 1)}}</td>
                <td>{{$player->PERS[$i]}}</td>
                <td>,{{$stats->TS}}</td>
                <td>{{$stats->EFF}}</td>
            </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
                
                @foreach($player->Stats as $stats)
                <tr>
                    <th scope="row">{{$stats->SeasonID}}</th>
                @if($stats->Team <> "NoTeam")
                    <td>{{$stats->Team}}</td>
                @endif
                    <td>{{$stats->G}}</td>
                    <td>{{$stats->GS}}</td>
                    <td>{{round($stats->MPG, 1)}}</td>
                    <td>{{round($stats->PPG, 1)}}</td>
                    <td>{{round($stats->APG, 1)}}</td>
                    <td>{{round($stats->RPG, 1)}}</td>
                    <td>{{round($stats->DRPG, 1)}}</td>
                    <td>{{round($stats->ORPG, 1)}}</td>
                    <td>{{round($stats->SPG, 1)}}</td>
                    <td>{{round($stats->BPG, 1)}}</td>
                    <td>{{round($stats->TOPG, 1)}}</td>
                    <td>{{$stats->Points}}</td>
                    <td>{{$stats->FGM}}</td>
                    <td>{{$stats->FGA}}</td>
                    <td>,{{$stats->FGP}}</td>
                    <td>{{$stats->FTM}}</td>
                    <td>{{$stats->FTA}}</td>
                    <td>,{{$stats->FTP}}</td>
                    <td>{{$stats->FG3PM}}</td>
                    <td>{{$stats->FG3PA}}</td>
                    <td>,{{$stats->FG3PP}}</td>
                    <td>{{round($stats->Assists, 1)}}</td>
                    <td>{{round($stats->DRebs, 1)}}</td>
                    <td>{{round($stats->ORebs, 1)}}</td>
                    <td>{{round($stats->Rebounds, 1)}}</td>
                    <td>{{round($stats->Steals, 1)}}</td>
                    <td>{{round($stats->Blocks, 1)}}</td>
                    <td>{{round($stats->Turnovers, 1)}}</td>
                    <td>{{round($stats->DQ, 1)}}</td>
                    <td>{{$player->PERS[$i]}}</td>
                    <td>,{{$stats->TS}}</td>
                    <td>{{$stats->EFF}}</td>
                </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
                </tr>
                    @if(isset($player->CareerRS['PRO']))      
                <tr>
                    <th scope="col">{{$player->CareerRS['PRO']['SeasonID']}}</th>
                    <td>{{$player->CareerRS['PRO']['CityName']}}</td>
                    <td>{{$player->CareerRS['PRO']['G']}}</td>
                    <td>{{$player->CareerRS['PRO']['GS']}}</td>
                    <td>{{round($player->CareerRS['PRO']['MPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['PPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['APG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['RPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['DRPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['ORPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['SPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['BPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['TOPG'], 1)}}</td>
                    <td>{{$player->CareerRS['PRO']['Points']}}</td>
                    <td>{{$player->CareerRS['PRO']['FGM']}}</td>
                    <td>{{$player->CareerRS['PRO']['FGA']}}</td>
                    <td>,{{$player->CareerRS['PRO']['FGP']}}</td>
                    <td>{{$player->CareerRS['PRO']['FTM']}}</td>
                    <td>{{$player->CareerRS['PRO']['FTA']}}</td>
                    <td>,{{$player->CareerRS['PRO']['FTP']}}</td>
                    <td>{{$player->CareerRS['PRO']['FG3PM']}}</td>
                    <td>{{$player->CareerRS['PRO']['FG3PA']}}</td>
                    <td>,{{$player->CareerRS['PRO']['FG3PP']}}</td>
                    <td>{{round($player->CareerRS['PRO']['Assists'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['DRebs'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['ORebs'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['Rebounds'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['Steals'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['Blocks'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['Turnovers'], 1)}}</td>
                    <td>{{round($player->CareerRS['PRO']['DQ'], 1)}}</td>
                    <td>{{$player->PERS[$c]}}</td>
                    <td>,{{$player->CareerRS['PRO']['TS']}}</td>
                    <td>{{$player->CareerRS['PRO']['EFF']}}</td>
                </tr>
                @endif
                @if(isset($player->CareerRS['DL']))
                <tr>
                    <th scope="col">{{$player->CareerRS['DL']['SeasonID']}}</th>
                    <td>{{$player->CareerRS['DL']['CityName']}}</td>
                    <td>{{$player->CareerRS['DL']['G']}}</td>
                    <td>{{$player->CareerRS['DL']['GS']}}</td>
                    <td>{{round($player->CareerRS['DL']['MPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['PPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['APG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['RPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['DRPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['ORPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['SPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['BPG'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['TOPG'], 1)}}</td>
                    <td>{{$player->CareerRS['DL']['Points']}}</td>
                    <td>{{$player->CareerRS['DL']['FGM']}}</td>
                    <td>{{$player->CareerRS['DL']['FGA']}}</td>
                    <td>,{{$player->CareerRS['DL']['FGP']}}</td>
                    <td>{{$player->CareerRS['DL']['FTM']}}</td>
                    <td>{{$player->CareerRS['DL']['FTA']}}</td>
                    <td>,{{$player->CareerRS['DL']['FTP']}}</td>
                    <td>{{$player->CareerRS['DL']['FG3PM']}}</td>
                    <td>{{$player->CareerRS['DL']['FG3PA']}}</td>
                    <td>,{{$player->CareerRS['DL']['FG3PP']}}</td>
                    <td>{{round($player->CareerRS['DL']['Assists'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['DRebs'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['ORebs'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['Rebounds'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['Steals'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['Blocks'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['Turnovers'], 1)}}</td>
                    <td>{{round($player->CareerRS['DL']['DQ'], 1)}}</td>
                    <td>{{$player->PERS[$c]}}</td>
                    <td>,{{$player->CareerRS['DL']['TS']}}</td>
                    <td>{{$player->CareerRS['DL']['EFF']}}</td>
                </tr>
                @endif
            </tbody>
        </table>
    @endif
    </div>

    <div class="overflow-auto" id="playoffStats">
        @if(sizeof($player->PlayoffStats) > 0)
        <table class="table oneline">
            <thead class="thead">
                <tr>
                    <th scope="col">Season</th>
                    <th scope="col">Team</th>
                    <th scope="col">G</th>
                    <th scope="col">GS</th>
                    <th scope="col">MPG</th>
                    <th scope="col">PPG</th>
                    <th scope="col">APG</th>
                    <th scope="col">RPG</th>
                    <th scope="col">DRPG</th>
                    <th scope="col">ORPG</th>
                    <th scope="col">SPG</th>
                    <th scope="col">BPG</th>
                    <th scope="col">TOPG</th>
                    <th scope="col">Points</th>
                    <th scope="col">FGM</th>
                    <th scope="col">FGA</th>
                    <th scope="col">FG%</th>
                    <th scope="col">FTM</th>
                    <th scope="col">FTA</th>
                    <th scope="col">FT%</th>
                    <th scope="col">3PM</th>
                    <th scope="col">3PA</th>
                    <th scope="col">3P%</th>
                    <th scope="col">Assists</th>
                    <th scope="col">DRebs</th>
                    <th scope="col">ORebs</th>
                    <th scope="col">Rebounds</th>
                    <th scope="col">Steals</th>
                    <th scope="col">Blocks</th>
                    <th scope="col">TOs</th>
                    <th scope="col">DQ</th>
                    <th scope="col">PER</th>
                    <th scope="col">TS%</th>
                    <th scope="col">EFF</th>
                </tr>
            </thead>
            <tbody> 
                @php
                    $c = count($player->PERSPO) - 1; 
                    $i = 0;  
                @endphp  
                @foreach($player->PlayoffStats as $stats)
                <tr>
                    @if($stats->SeasonID == "PBL Season" || $stats->SeasonID == "DBL Season")
                    <th scope="row">{{$player->CurrentSeason}}</th>
                    <th scope="row">{{$stats->SeasonID}}</th>  
                    @else
                    <th scope="row">{{$stats->SeasonID}}</th> 
                    <th scope="row">{{$stats->Team}}</th>
                    @endif
                    <td>{{$stats->G}}</td>
                    <td>{{$stats->GS}}</td>
                    <td>{{round($stats->MPG, 1)}}</td>
                    <td>{{round($stats->PPG, 1)}}</td>
                    <td>{{round($stats->APG, 1)}}</td>
                    <td>{{round($stats->RPG, 1)}}</td>
                    <td>{{round($stats->DRPG, 1)}}</td>
                    <td>{{round($stats->ORPG, 1)}}</td>
                    <td>{{round($stats->SPG, 1)}}</td>
                    <td>{{round($stats->BPG, 1)}}</td>
                    <td>{{round($stats->TOPG, 1)}}</td>
                    <td>{{$stats->Points}}</td>
                    <td>{{$stats->FGM}}</td>
                    <td>{{$stats->FGA}}</td>
                    <td>,{{$stats->FGP}}</td>
                    <td>{{$stats->FTM}}</td>
                    <td>{{$stats->FTA}}</td>
                    <td>,{{$stats->FTP}}</td>
                    <td>{{$stats->FG3PM}}</td>
                    <td>{{$stats->FG3PA}}</td>
                    <td>,{{$stats->FG3PP}}</td>
                    <td>{{round($stats->Assists, 1)}}</td>
                    <td>{{round($stats->DRebs, 1)}}</td>
                    <td>{{round($stats->ORebs, 1)}}</td>
                    <td>{{round($stats->Rebounds, 1)}}</td>
                    <td>{{round($stats->Steals, 1)}}</td>
                    <td>{{round($stats->Blocks, 1)}}</td>
                    <td>{{round($stats->Turnovers, 1)}}</td>
                    <td>{{round($stats->DQ, 1)}}</td>
                    <td>{{$player->PERSPO[$i]}}</td>
                    <td>,{{$stats->TS}}</td>
                    <td>{{$stats->EFF}}</td>
                </tr>
                @php
                    $i++;
                @endphp
                @endforeach
                @if(isset($player->CareerPO['PRO']))      
                <tr>
                    <th scope="col">{{$player->CareerPO['PRO']['SeasonID']}}</th>
                    <td>{{$player->CareerPO['PRO']['CityName']}}</td>
                    <td>{{$player->CareerPO['PRO']['G']}}</td>
                    <td>{{$player->CareerPO['PRO']['GS']}}</td>
                    <td>{{round($player->CareerPO['PRO']['MPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['PPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['APG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['RPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['DRPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['ORPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['SPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['BPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['TOPG'], 1)}}</td>
                    <td>{{$player->CareerPO['PRO']['Points']}}</td>
                    <td>{{$player->CareerPO['PRO']['FGM']}}</td>
                    <td>{{$player->CareerPO['PRO']['FGA']}}</td>
                    <td>,{{$player->CareerPO['PRO']['FGP']}}</td>
                    <td>{{$player->CareerPO['PRO']['FTM']}}</td>
                    <td>{{$player->CareerPO['PRO']['FTA']}}</td>
                    <td>,{{$player->CareerPO['PRO']['FTP']}}</td>
                    <td>{{$player->CareerPO['PRO']['FG3PM']}}</td>
                    <td>{{$player->CareerPO['PRO']['FG3PA']}}</td>
                    <td>,{{$player->CareerPO['PRO']['FG3PP']}}</td>
                    <td>{{round($player->CareerPO['PRO']['Assists'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['DRebs'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['ORebs'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['Rebounds'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['Steals'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['Blocks'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['Turnovers'], 1)}}</td>
                    <td>{{round($player->CareerPO['PRO']['DQ'], 1)}}</td>
                    <td>{{$player->PERS[$c]}}</td>
                    <td>,{{$player->CareerPO['PRO']['TS']}}</td>
                    <td>{{$player->CareerPO['PRO']['EFF']}}</td>
                </tr>
                @endif
                @if(isset($player->CareerPO['DL']))
                <tr>
                    <th scope="col">{{$player->CareerPO['DL']['SeasonID']}}</th>
                    <td>{{$player->CareerPO['DL']['CityName']}}</td>
                    <td>{{$player->CareerPO['DL']['G']}}</td>
                    <td>{{$player->CareerPO['DL']['GS']}}</td>
                    <td>{{round($player->CareerPO['DL']['MPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['PPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['APG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['RPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['DRPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['ORPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['SPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['BPG'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['TOPG'], 1)}}</td>
                    <td>{{$player->CareerPO['DL']['Points']}}</td>
                    <td>{{$player->CareerPO['DL']['FGM']}}</td>
                    <td>{{$player->CareerPO['DL']['FGA']}}</td>
                    <td>,{{$player->CareerPO['DL']['FGP']}}</td>
                    <td>{{$player->CareerPO['DL']['FTM']}}</td>
                    <td>{{$player->CareerPO['DL']['FTA']}}</td>
                    <td>,{{$player->CareerPO['DL']['FTP']}}</td>
                    <td>{{$player->CareerPO['DL']['FG3PM']}}</td>
                    <td>{{$player->CareerPO['DL']['FG3PA']}}</td>
                    <td>,{{$player->CareerPO['DL']['FG3PP']}}</td>
                    <td>{{round($player->CareerPO['DL']['Assists'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['DRebs'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['ORebs'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['Rebounds'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['Steals'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['Blocks'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['Turnovers'], 1)}}</td>
                    <td>{{round($player->CareerPO['DL']['DQ'], 1)}}</td>
                    <td>{{$player->PERS[$c]}}</td>
                    <td>,{{$player->CareerPO['DL']['TS']}}</td>
                    <td>{{$player->CareerPO['DL']['EFF']}}</td>
                </tr>
                @endif
            </tbody>
        </table>
    @endif
    </div>

</div>

<script>

    $('table.table.oneline').stickyTableHeaders();
  
  </script>

</section>

@endsection