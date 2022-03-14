@extends('layout')

@section('css')
<style type="text/css">
.mr-2 .row .col-md button{
    background: {{$teamColor}};
}

{{implode(",", $player['PlayerType'])}} {
    opacity: 1;
}
</style>
@endsection

@include('html.player_top')

<div class="container mr-2" role="group" aria-label="Player Options">
    <div class="row">
      <div class="col-md">
        <button type="button" class="btn btn-secondary active disabled">Player Bio</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(2);" class="btn btn-secondary">Player Profile</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(3);" class="btn btn-secondary">Player Stats</button>
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

<div class="bottom_pro table-responsive">
    <div class="skill-ratings">
        <h2>Skill Ratings</h2>
        <hr/>
        <div class="row">
            <div class="col rat">
                INSIDE SHOOTING<br/>
                <span>{{$player->Inside_Rating}}</span>
                {!! progress($player->Inside_Rating, "") !!}
            </div>
            <div class="col rat">
                OUTSIDE SHOOTING<br/>
                <span>{{$player->Outside_Rating}}</span>
                {!! progress($player->Outside_Rating, "") !!}
            </div>
            <div class="col rat">
                FREE THROWS<br/>
                <span>{{$player->FT}}</span>
                {!! progress($player->FT, "") !!}
            </div>
        </div>
        <div class="row">
            <div class="col rat">
                SCORING<br/>
                <span>{{$player->Scoring}}</span>
                {!! progress($player->Scoring, "") !!}
            </div>
            <div class="col rat">
                PASSING<br/>
                <span>{{$player->Passing}}</span>
                {!! progress($player->Passing, "") !!}
            </div>
            <div class="col rat">
                BALL HANDLING<br/>
                <span>{{$player->Handling}}</span>
                {!! progress($player->Handling, "") !!}
            </div>
        </div>
        <div class="row">
            <div class="col rat">
                OFF. REBOUNDING<br/>
                <span>{{$player->OReb}}</span>
                {!! progress($player->OReb, "") !!}
            </div>
            <div class="col rat">
                DEF. REBOUNDING<br/>
                <span>{{$player->DReb}}</span>
                {!! progress($player->DReb, "") !!}
            </div>
            <div class="col rat">
                DRAWING FOULS<br/>
                <span>{{$player->DrawingFouls}}</span>
                {!! progress($player->DrawingFouls, "") !!}
            </div>
        </div>
        <div class="row">
            <div class="col rat">
                DEFENSIVE ABILITY<br/>
                <span>{{$player->Defender}}</span>
                {!! progress($player->Defender, "") !!}
            </div>
            <div class="col rat">
                SHOT BLOCKING<br/>
                <span>{{$player->Block}}</span>
                {!! progress($player->Block, "") !!}
            </div>
            <div class="col rat">
                STEALING<br/>
                <span>{{$player->Steal}}</span>
                {!! progress($player->Steal, "") !!}
            </div>
        </div>
        <div class="row">
            <div class="col rat">
                DISCIPLINE<br/>
                <span>{{$player->Discipline}}</span>
                {!! progress($player->Discipline, "") !!}
            </div>
            <div class="col rat">
                COURT IQ<br/>
                <span>{{$player->BballIQ}}</span>
                {!! progress($player->BballIQ, "") !!}
            </div>
            <div class="col rat">
                ENDURANCE<br/>
                <span>{{$player->Endurance}}</span>
                {!! progress($player->Endurance, "") !!}
            </div>
        </div>
    </div>

    <div class="bloq2">
        <div class="d-flex flex-column player-types">
            <h2>Player Types</h2>
            <hr/>
            <div class="container">
                <div class="row player-types">
                    <div class="col">
                        <i {{$dataToggle[0]}} title="Bucket Getter" class="fa-solid fa-fill fa-2x"></i>
                    </div>
                    <div class="col">
                        <i {{$dataToggle[1]}} title="Sharpshooter"class="fa-solid fa-crosshairs fa-2x"></i>
                    </div>
                    <div class="col">
                        <i {{$dataToggle[2]}} title="Attacker" class="fa-solid fa-bolt-lightning fa-2x"></i>
                    </div>
                    <div class="col">
                        <i {{$dataToggle[3]}} title="Paint Dominator" class="fa-solid fa-paint-roller fa-2x"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <i {{$dataToggle[4]}} title="Ball Magician" class="fa-solid fa-hat-wizard fa-2x"></i>
                    </div>
                    <div class="col">
                        <i {{$dataToggle[5]}} title="Playmaker" class="fa-solid fa-wand-magic-sparkles fa-2x"></i>
                    </div>
                    <div class="col">
                        <i {{$dataToggle[6]}} title="Defender" class="fa-solid fa-shield fa-2x"></i>
                    </div>
                    <div class="col">
                        <i {{$dataToggle[7]}} title="Clean Up" class="fa-solid fa-paintbrush fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column contract">
            <h2>Contract Information</h2>
            <hr/>
            <div class="p-2"><b>{{$player->CurrentSeason}}-{{$player->CurrentSeason+1}}: </b>
        {{moneyFormat($player->ContractYear1)}}</div>
            <div class="p-2"><b>{{$player->CurrentSeason+1}}-{{$player->CurrentSeason+2}}: </b>
        {{moneyFormat($player->ContractYear2)}}</div>
            <div class="p-2"><b>{{$player->CurrentSeason+2}}-{{$player->CurrentSeason+3}}: </b>
        {{moneyFormat($player->ContractYear3)}}</div>
            <div class="p-2"><b>{{$player->CurrentSeason+3}}-{{$player->CurrentSeason+4}}: </b>
        {{moneyFormat($player->ContractYear4)}}</div>
            <div class="p-2"><b>{{$player->CurrentSeason+4}}-{{$player->CurrentSeason+5}}: </b>
        {{moneyFormat($player->ContractYear5)}}</div>
            <div class="p-2"><b>Bird Years: </b>{{$player->BirdYears}}</div>
            <div class="p-2"><b>Extension Eligible: </b>{{$player->ExtensionElegible}}</div>
            <div class="p-2"><b>Option Eligible: </b>{{$player->OptionElegible}}</div>
        </div>

        <div class="bests">
            <h2>Career Bests & Achievements</h2>
            <hr/>
            <div class="d-flex flex-row">
                <div class="p-2"><ul>
                    <li><b>Points: </b>{{$player->Achievements['Points']}}</li>
                    <li><b>Assists: </b>{{$player->Achievements['Assists']}}</li>
                    <li><b>Rebounds: </b>{{$player->Achievements['Rebounds']}}</li>
                    <li><b>Blocks: </b>{{$player->Achievements['Blocks']}}</li>
                    <li><b>Steals: </b>{{$player->Achievements['Steals']}}</li>
                    <li><b>Double Doubles: </b>{{$player->Achievements['Double Doubles']}}</li>
                    <li><b>Triple Doubles: </b>{{$player->Achievements['Triple Doubles']}}</li></ul>
                </div>
                <div class="p-2"><ul>
                    <li><b>All Star Games: </b>{{$player->Achievements['All Star Games']}}</li>
                    <li><b>Titles Won: </b>{{$player->Achievements['Titles Won']}}</li>
                    <li><b>Player of the Game: </b>{{$player->Achievements['Player of the Game']}}</li>
                    <li><b>Player of the Week: </b>{{$player->Achievements['Player of the Week']}}</li>
                    <li><b>Player of the Month: </b>{{$player->Achievements['Player of the Month']}}</li>
                    <li><b>Rookie of the Month: </b>{{$player->Achievements['Rookie of the Month']}}</li></ul>
                </div>
            </div>     
        </div>
    </div>

    <div class="bloq3">
        <div id="FloorRate">
            <script type="text/javascript">
                $(function() {
                    // Create the chart
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'FloorRate',
                            type: 'pie'
                        },
                        title: {
                            text: '<b>Floor Range By Percentage</b>'
                        },
                        yAxis: {
                            title: {
                                text: 'FloorRange'
                            }
                        },
                        plotOptions: {
                            pie: {
                                shadow: false
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
                            }
                        },
                        series: [{
                            name: 'Floor Range By Percentage',
                                data: [
                                    ["Paint",<?php print($player->LocPaint); ?>],
                                    ["Midrange",<?php print($player->LocMidrange); ?>],
                                    ["Corner Three",<?php print($player->LocCorner); ?>],
                                    ["Above The Break",<?php print($player->LocATB); ?>]
                                ],
                            size: '60%',
                            innerSize: '20%',
                            showInLegend:true,
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    });
                });
            </script>
        </div>
        <div id="BallActions">
        <script type="text/javascript">
                $(function() {
                    // Create the chart
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'BallActions',
                            type: 'pie'
                        },
                        title: {
                            text: '<b>Ball Actions By Percentage</b>'
                        },
                        yAxis: {
                            title: {
                                text: 'BallActions'
                            }
                        },
                        plotOptions: {
                            pie: {
                                shadow: false
                            }
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
                            }
                        },
                        series: [{
                            name: 'Ball Actions By Percentage',
                                data: [
                                    ["Drive & Pass",<?php print($player->DriveKick); ?>],
                                    ["Drive & Shoot",<?php print($player->DriveShot); ?>],
                                    ["Catch & Shoot",<?php print($player->CS); ?>],
                                    ["Pull Up Jumper",<?php print($player->PullUp); ?>],
                                    ["Post Up Shot",<?php print($player->PostUp); ?>],
                                    ["Pass",<?php print($player->Pass); ?>]
                                ],
                            size: '60%',
                            innerSize: '20%',
                            showInLegend:true,
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    });
                });
            </script>
        </div>
    </div>

</div>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

</section>

@endsection