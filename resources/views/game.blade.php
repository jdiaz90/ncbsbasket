@extends('layout')

@section('title')
{{$schedule->Visitor}} @ {{$schedule->Home}} - {{ config('app.name') }}
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="/js/sortable/sortable.js"></script>
@endsection

@section('description')
Toda la información sobre en la liga {{ config('app.name') }}.
@endsection

@section('section')

<section>

<div class="table-responsive">
    <table id="score">
        <tr>
            <td class="scoreLeftSide" 
            style="background-color: {{$schedule->VisitorColor}}; 
            background-image: url('{{$schedule->VisitorLogo}}');">
            <b>{{$schedule->Visitor}}<br/>
                {{$stats['VisitorFinal']}}</b></td>
            <td>
                <table class="score">
                    <tr>
                        <td class="score-title" colspan="7">Final Score 
                            @if ($schedule->gameLogExists())
                            - <a href="{{$schedule->GameLog}}">View Game Log</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>OT</td>
                        <td>F</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{$schedule->VisitorQ1}}</td>
                        <td>{{$schedule->VisitorQ2 - $schedule->VisitorQ1}}</td>
                        <td>{{$schedule->VisitorQ3 - $schedule->VisitorQ2}}</td>
                        <td>{{$schedule->VisitorQ4 - $schedule->VisitorQ3}}</td>
                    @if ($schedule->VisitorOT == 0)
                        <td>-</td>
                        <td>{{$schedule->VisitorQ4}}</td>
                    @else
                        <td>{{($schedule->VisitorOT - $schedule->VisitorQ4)}}</td>
                        <td>{{$schedule->VisitorOT}}</td>
                    @endif
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{$schedule->HomeQ1}}</td>
                        <td>{{$schedule->HomeQ2 - $schedule->HomeQ1}}</td>
                        <td>{{$schedule->HomeQ3 - $schedule->HomeQ2}}</td>
                        <td>{{$schedule->HomeQ4 - $schedule->HomeQ3}}</td>
                    @if ($schedule->VisitorOT == 0) 
                        <td>-</td>
                        <td>{{$schedule->HomeQ4}}</td>
                        @else
                        <td>{{($schedule->HomeOT - $schedule->HomeQ4)}}</td> 
                        <td>{{$schedule->HomeOT}}</td>
                    @endif
                    </tr>
            </table></td>
            <td class="scoreRightSide"
            style="background-color: {{$schedule->HomeColor}}; 
            background-image: url('{{$schedule->HomeLogo}}');">
            <b>{{$schedule->Home}}<br/>{{$stats['HomeFinal']}}</b></td>
        </tr>
    </table>
</div>

<h1 class="team"><img width="32px" src="{{$schedule->VisitorLogo}}" />{{$schedule->Visitor}}</h1>
<div class="table-responsive">
    <table class="table sortable">
        <thead class="thead">
            <tr>
                <th scope="col">PLAYER</th>
                <th scope="col">MIN</th>
                <th scope="col">FG</th>
                <th scope="col">3PT</th>
                <th scope="col">FT</th>
                <th scope="col">OREB</th>
                <th scope="col">DREB</th>
                <th scope="col">REB</th>
                <th scope="col">AST</th>
                <th scope="col">STL</th>
                <th scope="col">BLK</th>
                <th scope="col">TO</th>
                <th scope="col">PF</th>
                <th scope="col">PTS</th>
                <th scope="col">+/</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($stats['Visitor'] as $player)
            @if ($player['Minutes'] > 0)
            <tr>
                <td data-sort="{{$player->LastName}}"><a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}">{{$player->playerName}}</a></td>
                <td>{{round($player['Minutes'], 0)}}</td>
                <td data-sort="{{$player['FGM']}}}}">{{$player['FGM']}}-{{$player['FGA']}}</td>
                <td data-sort="{{$player['FG3PM']}}}}">{{$player['FG3PM']}}-{{$player['FG3PA']}}</td>
                <td data-sort="{{$player['FTM']}}}}">{{$player['FTM']}}-{{$player['FTA']}}</td>
                <td>{{$player['ORebs']}}</td>
                <td>{{$player['DRebs']}}</td>
                <td>{{$player['ORebs'] + $player['DRebs']}}</td>
                <td>{{$player['Assists']}}</td>
                <td>{{$player['Steals']}}</td>
                <td>{{$player['Blocks']}}</td>
                <td>{{$player['Turnovers']}}</td>
                <td>{{$player['Fouls']}}</td>
                <td>{{$player['Points']}}</td>
                <td>{{$player['PlusMinus']}}</td>
            </tr>  
            @endif
        @endforeach
        </tbody>
        <tbody class="not-sort">
        @foreach ($stats['Visitor'] as $player)
            @if ($player['Minutes'] == 0)
            <tr>
                <td><a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}">{{$player->playerName}}</a></td>
                <td class="dnp" colspan="14">DNP - Coach's Decision</td>
            </tr>
            @endif
        @endforeach
            <tr>
                <td colspan="2">TEAM</td>
                <td>{{$stats['Visitor']->sum('FGM')}}-{{$stats['Visitor']->sum('FGA')}}</td>
                <td>{{$stats['Visitor']->sum('FG3PM')}}-{{$stats['Visitor']->sum('FG3PA')}}</td>
                <td>{{$stats['Visitor']->sum('FTM')}}-{{$stats['Visitor']->sum('FTA')}}</td>
                <td>{{$stats['Visitor']->sum('ORebs')}}</td>
                <td>{{$stats['Visitor']->sum('DRebs')}}</td>
                <td>{{$stats['Visitor']->sum('ORebs') + $stats['Visitor']->sum('DRebs')}}</td>
                <td>{{$stats['Visitor']->sum('Assists')}}</td>
                <td>{{$stats['Visitor']->sum('Steals')}}</td>
                <td>{{$stats['Visitor']->sum('Blocks')}}</td>
                <td>{{$stats['Visitor']->sum('Turnovers')}}</td>
                <td>{{$stats['Visitor']->sum('Fouls')}}</td>
                <td colspan="2">{{$stats['Visitor']->sum('Points')}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{round($stats['Visitor']->sum('FGM') / $stats['Visitor']->sum('FGA') * 100,  1)}}%</td>
                <td>{{round($stats['Visitor']->sum('FG3PM') / $stats['Visitor']->sum('FG3PA') * 100,  1)}}%</td>
                <td colspan="11">{{round($stats['Visitor']->sum('FTM') / $stats['Visitor']->sum('FTA') * 100,  1)}}%</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive">
    <h1 class="team"><img width="32px" src="{{$schedule->HomeLogo}}" />{{$schedule->Home}}</h1>
    <table class="table sortable">
        <thead class="thead">
            <tr>
                <th scope="col">PLAYER</th>
                <th scope="col">MIN</th>
                <th scope="col">FG</th>
                <th scope="col">3PT</th>
                <th scope="col">FT</th>
                <th scope="col">OREB</th>
                <th scope="col">DREB</th>
                <th scope="col">REB</th>
                <th scope="col">AST</th>
                <th scope="col">STL</th>
                <th scope="col">BLK</th>
                <th scope="col">TO</th>
                <th scope="col">PF</th>
                <th scope="col">PTS</th>
                <th scope="col">+/</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($stats['Home'] as $player)
            @if ($player['Minutes'] > 0)
            <tr>
                <td data-sort="{{$player->LastName}}"><a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}">{{$player->playerName}}</a></td>
                <td>{{round($player['Minutes'], 0)}}</td>
                <td data-sort="{{$player['FGM']}}}}">{{$player['FGM']}}-{{$player['FGA']}}</td>
                <td data-sort="{{$player['FG3PM']}}}}">{{$player['FG3PM']}}-{{$player['FG3PA']}}</td>
                <td data-sort="{{$player['FTM']}}}}">{{$player['FTM']}}-{{$player['FTA']}}</td>
                <td>{{$player['ORebs']}}</td>
                <td>{{$player['DRebs']}}</td>
                <td>{{$player['ORebs'] + $player['DRebs']}}</td>
                <td>{{$player['Assists']}}</td>
                <td>{{$player['Steals']}}</td>
                <td>{{$player['Blocks']}}</td>
                <td>{{$player['Turnovers']}}</td>
                <td>{{$player['Fouls']}}</td>
                <td>{{$player['Points']}}</td>
                <td>{{$player['PlusMinus']}}</td>
            </tr>  
            @endif
        @endforeach
        </tbody>
        <tbody class="not-sort">
        @foreach ($stats['Home'] as $player)
            @if ($player['Minutes'] == 0)
            <tr>
                <td><a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}">{{$player->playerName}}</a></td>
                <td class="dnp" colspan="14">DNP - Coach's Decision</td>
            </tr>
            @endif
        @endforeach
            <tr>
                <td colspan="2">TEAM</td>
                <td>{{$stats['Home']->sum('FGM')}}-{{$stats['Home']->sum('FGA')}}</td>
                <td>{{$stats['Home']->sum('FG3PM')}}-{{$stats['Home']->sum('FG3PA')}}</td>
                <td>{{$stats['Home']->sum('FTM')}}-{{$stats['Home']->sum('FTA')}}</td>
                <td>{{$stats['Home']->sum('ORebs')}}</td>
                <td>{{$stats['Home']->sum('DRebs')}}</td>
                <td>{{$stats['Home']->sum('ORebs') + $stats['Home']->sum('DRebs')}}</td>
                <td>{{$stats['Home']->sum('Assists')}}</td>
                <td>{{$stats['Home']->sum('Steals')}}</td>
                <td>{{$stats['Home']->sum('Blocks')}}</td>
                <td>{{$stats['Home']->sum('Turnovers')}}</td>
                <td>{{$stats['Home']->sum('Fouls')}}</td>
                <td colspan="2">{{$stats['Home']->sum('Points')}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{round($stats['Home']->sum('FGM') / $stats['Home']->sum('FGA') * 100,  1)}}%</td>
                <td>{{round($stats['Home']->sum('FG3PM') / $stats['Home']->sum('FG3PA') * 100,  1)}}%</td>
                <td colspan="11">{{round($stats['Home']->sum('FTM') / $stats['Home']->sum('FTA') * 100,  1)}}%</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="container">
    <div class="row">
      <div class="col-md">

        <div class="container">
            <div class="row">
              <div class="col">
                <h1>Player of the Game</h1>
              </div>
            </div>
            <div class="row align-items-start">
                <div class="col">
                    <img src="{{$schedule->MVPPhoto}}" />
                </div>
                <div class="col">
                    <div>
                        <h2>{{$schedule->POTG}}</h2>
                        <h3>{{$schedule->MVPPosition}}</h3>
                
                        <table>
                            <tr>
                                <td><b>Points:</b> {{$stats['MVP']->Points}} </td>
                            </tr>
                            <tr>
                                <td><b>Assists:</b> {{$stats['MVP']->Assists}} </td>
                            </tr>
                            <tr>
                                <td><b>Rebounds:</b> {{$stats['MVP']->Rebs}} </td>
                            </tr>
                            <tr>
                                <td><b>Blocks:</b> {{$stats['MVP']->Blocks}} </td>
                            </tr>
                            <tr>
                                <td><b>Steals:</b> {{$stats['MVP']->Steals}} </td>
                            </tr>
                        </table>
                
                    </div>
                </div>
              </div>
          </div>

      </div>
      <div class="col-md" id="dayStats">
        <script type="text/javascript">
            Highcharts.chart('dayStats', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: '<h1>Team Stats</h1>'
                },
                xAxis: {
                    categories: ['Points', 'Assists', 'Rebounds', 'Steals', 'Blocks'],
                },
                
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 100,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },
                series: [{
                    name: '<?php print($schedule->Visitor)?>',
                    color: '<?php print($schedule->VisitorColor)?>',
                    data: [
                        <?php print($stats['Visitor']->sum('Points'))?>, 
                        <?php print($stats['Visitor']->sum('Assists'))?>, 
                        <?php print($stats['Visitor']->sum('Rebounds'))?>, 
                        <?php print($stats['Visitor']->sum('Steals'))?>, 
                        <?php print($stats['Visitor']->sum('Blocks'))?>, 
                        ]
                }, {
                    name: '<?php print($schedule->Home)?>',
                    color: '<?php print($schedule->HomeColor)?>',
                    data: [
                        <?php print($stats['Home']->sum('Points'))?>, 
                        <?php print($stats['Home']->sum('Assists'))?>, 
                        <?php print($stats['Home']->sum('Rebounds'))?>, 
                        <?php print($stats['Home']->sum('Steals'))?>, 
                        <?php print($stats['Home']->sum('Blocks'))?>, 
                        ]
                },
                ]
                });
        </script>
      </div>
    </div>
  </div>

  <script>

    $('table.table.sortable').stickyTableHeaders();

    </script>

</section>

@endsection
