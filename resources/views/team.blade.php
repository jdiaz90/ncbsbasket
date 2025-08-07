@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
    @include('js/changeURL')
</script>
@endsection

@php

    use \App\Http\Controllers\TeamController;

    $pie = [];
    $points = [];
    $assists = [];
    $rebounds = [];
    $i = 0;

    foreach($team->PIE as $key => $value){
        array_push($pie, $key);
        array_push($pie, $value);
        $i++;
    }

    foreach($team->Leaders[0] as $key => $value){
        array_push($points, $key);
        array_push($points, $value);
        $i++;
    }

    foreach($team->Leaders[1] as $key => $value){
        array_push($assists, $key);
        array_push($assists, $value);
        $i++;
    }

    foreach($team->Leaders[2] as $key => $value){
        array_push($rebounds, $key);
        array_push($rebounds, $value);
        $i++;
    }

@endphp

@section('section')

<section>

@include('html.team_top')
<div style="width:100%;">
    <div class="playersRoster">
        @foreach ($team->Players as $player)
        <div class="cardPlayer" onclick="window.location='/player/{{$player->PlayerID}}';">
            <div class="photoDiv">
                <div class="imgPlayer">
                <img class="playerPhotoTeamPage" src="{{$player->playerPhoto}} 
                "onerror="this.onerror=null; this.src='/images/players/default.png';">
                </div>
                
                <div class="playerNameDiv">
                    <div><b>#{{$player->JerseyNum}} | {{$player->abPosition}}</b></div>
                    <div><b>{{$player->FirstName}}</b></div>
                    <div><b>{{$player->LastName}}</b></div>
                </div>

            </div>
            <div>
                    <div>
                        {{$player->Feet}}-{{$player->Inches}} / 
                        {{$player->Weight}}lbs. / 
                        {{$player->Age}} years old
                    </div>
                    <div>
                        <img width="16px" src="{{$player->countryFlag}}" />
                        {{$player->College}} / 
                        {{$player->experience("yr", false)}}
                    </div>
                    <div>
                    @for($i = 0; $i < $player->currentRating()[0]; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg>
                    @endfor
                    @for($i = 0; $i < $player->currentRating()[1]; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="#ffc40c" class="bi bi-star-half" viewBox="0 0 16 16">
                        <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                    </svg>
                    @endfor
                    </div>
                    <div>
                        {{$player->PPG}} PPG - {{$player->APG}} APG - {{$player->RPG}} RPG
                    </div>
                    <div>
                        {{"$" . number_format($player->ContractYear1, "0", ",", ".")}}
                    </div>
                    <div>Iconos</div>
            </div>
        </div>
        @endforeach
    </div>
</div>


<div class="teamBottom">

    <div class="mediaNews">
        <h1>Media News</h1>
        <hr/>
        @if(sizeof($team->Transactions) > 0)
        <div class="mediaNewsTable card overflow-auto">
        @foreach($team->Transactions as $transaction)
            <div class="card-header">
                <b>{{$transaction->Title}}</b>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{$transaction->Story}}</li>
            </ul>
            <div class="dateNews">
                {{ $transaction->days ? $transaction->days->DayNumber : $transaction->Day }}
            </div>

        @endforeach
        </div>
        @endif
    </div>

    <div class="part2">
        <div id="PIEGraph">
            <script type="text/javascript">
                Highcharts.chart('PIEGraph', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },
                    title: {
                        text: '<h1>Player Impact Estimate (PIE)</h1>',
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                enabled: true,
                                distance: -50,
                                style: {
                                    fontWeight: 'bold',
                                    color: 'white'
                                }
                            },
                            startAngle: -90,
                            endAngle: 90,
                            center: ['50%', '75%'],
                            size: '110%'
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Player Impact Estimate (PIE)',
                        innerSize: '50%',
                        data: [
                            ["<?php print($pie[0]); ?>",<?php print($pie[1]); ?>],
                            ["<?php print($pie[2]); ?>",<?php print($pie[3]); ?>],
                            ["<?php print($pie[4]); ?>",<?php print($pie[5]); ?>],
                            ["<?php print($pie[6]); ?>",<?php print($pie[7]); ?>],
                            ["<?php print($pie[8]); ?>",<?php print($pie[9]); ?>],
                            ["<?php print($pie[10]); ?>",<?php print($pie[11]); ?>],
                            ["<?php print($pie[12]); ?>",<?php print($pie[13]); ?>],
                            ["<?php print($pie[14]); ?>",<?php print($pie[15]); ?>],
                        ]
                    }]
                });
            </script>
        </div>

        <div id="PointsGraph">
                {!! TeamController::htmlCodeLeaders($points, "Scoring", "Points", "points")!!}
        </div>

    </div>

    <div class="part3">

        <div id="AssistsGraph">
            {!! TeamController::htmlCodeLeaders($assists, "Passing", "Assists", "assists")!!}
        </div>

        <div id="ReboundsGraph">
            {!! TeamController::htmlCodeLeaders($rebounds, "Rebounding", "Rebounds", "rebounds")!!}
        </div>  

    </div> 

</div>

</section>

@endsection