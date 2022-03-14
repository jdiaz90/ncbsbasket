@extends('layout')

@section('title')
{{$stats[0]->PlayerName}} - 
{{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$stats[0]->PlayerName}},
ex-jugador de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">

    <div class="container table-responsive">
        <div class="row">
            <div class="col formerPlayerIMG">
                <img src="/images/players/{{str_replace(" ", "_", $stats[0]->PlayerName . ".png")}}"
                onerror="this.onerror=null; this.src='/images/players/default.png';">
            </div>
            <div class="col">
                <h1 id="formerPlayer">{{$stats[0]->PlayerName}}</h1>
                <div class="d-flex flex-row stats2">
                    <div class="p-2"><span>{{round($stats->avg('PPG'), 1)}}</span><br/>POINTS<br/>PER GAME</div>
                    <div class="p-2"><span>{{round($stats->avg('APG'), 1)}}</span><br/>ASSISTS<br/>PER GAME</div>
                    <div class="p-2"><span>{{round($stats->avg('RPG'), 1)}}</span><br/>REBOUNDS<br/>PER GAME</div>
                    <div class="p-2"><span>{{round($stats->avg('BPG'), 1)}}</span><br/>BLOCKS<br/>PER GAME</div>
                    <div class="p-2"><span>{{round($stats->avg('SPG'), 1)}}</span><br/>STEALS<br/>PER GAME</div>
                </div>
            </div>
        </div>
      </div>

    
    @if ($awards->count() == 0)
    <div class="retiredStats" style="width: 100%">
    @else
    <div class="retiredStats table-responsive">
    @endif
        <h2>Career Statistics</h2>
        <hr/>
        <table class="table">
            <thead>
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
                    <th scope="col">TS%</th>
                    <th scope="col">EFF</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                <tr>
                    <th scope="row">{{$stat->SeasonID}}</th>
                    <th scope="row">{{$stat->Team}}</th>
                    <td>{{$stat->G}}</td>
                    <td>{{$stat->GS}}</td>
                    <td>{{round($stat->MPG, 1)}}</td>
                    <td>{{round($stat->PPG, 1)}}</td>
                    <td>{{round($stat->APG, 1)}}</td>
                    <td>{{round($stat->RPG, 1)}}</td>
                    <td>{{round($stat->DRPG, 1)}}</td>
                    <td>{{round($stat->ORPG, 1)}}</td>
                    <td>{{round($stat->SPG, 1)}}</td>
                    <td>{{round($stat->BPG, 1)}}</td>
                    <td>{{round($stat->TOPG, 1)}}</td>
                    <td>{{$stat->Points}}</td>
                    <td>{{$stat->FGM}}</td>
                    <td>{{$stat->FGA}}</td>
                    <td>,{{$stat->FGP}}</td>
                    <td>{{$stat->FTM}}</td>
                    <td>{{$stat->FTA}}</td>
                    <td>,{{$stat->FTP}}</td>
                    <td>{{$stat->FG3PM}}</td>
                    <td>{{$stat->FG3PA}}</td>
                    <td>,{{$stat->FG3PP}}</td>
                    <td>{{round($stat->Assists, 1)}}</td>
                    <td>{{round($stat->DRebs, 1)}}</td>
                    <td>{{round($stat->ORebs, 1)}}</td>
                    <td>{{round($stat->Rebounds, 1)}}</td>
                    <td>{{round($stat->Steals, 1)}}</td>
                    <td>{{round($stat->Blocks, 1)}}</td>
                    <td>{{round($stat->Turnovers, 1)}}</td>
                    <td>{{round($stat->DQ, 1)}}</td>
                    <td>,{{$stat->TS}}</td>
                    <td>{{$stat->EFF}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($awards->count() > 0)
    <div class="retiredAwards table-responsive">
        <h2>Awards Won</h2>
        <hr/>
        <table class="table">
            <tbody>
                @foreach ($awards as $award)
                <tr>
                    <td>{{$award->Season}} - {{$award->AwardName}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</section>
    
@endsection