@extends('layout')

@include('html.coach_top')

<div class="bottom_pro">

    <div id="spider">

        <script>

            Highcharts.chart('spider', {

                chart: {
                    polar: true,
                    type: 'area'
                },

                accessibility: {
                    description: '{{$coach->Full_Name}} Skill Ratings'
                },

                title: {
                    text: 'Skill Ratings',
                    x: -80
                },

                pane: {
                    size: '80%'
                },

                xAxis: {
                    categories: ['Evaluate Offense', 'Evaluate Defense', 'Evaluate Potential', 'Player Development',
                        'Strategy'],
                    tickmarkPlacement: 'on',
                    lineWidth: 0
                },

                yAxis: {
                    gridLineInterpolation: 'polygon',
                    lineWidth: 0,
                    min: 0,
                    tickPositions: [20, 40, 60, 80, 100]
                },

                tooltip: {
                    shared: true,
                    pointFormat: '<span style="color:{series.color}">Skills Area: <b>{point.y:,.0f}</b><br/>'
                },

                series: [{
                    name: '<?php print($coach->Full_Name); ?>',
                    color: '<?php print($coach->TeamColor2); ?>',
                    fillColor: '<?php print($coach->TeamColor); ?>',
                    data: [
                        <?php print($coach->EvalOff); ?>, 
                        <?php print($coach->EvalDef); ?>, 
                        <?php print($coach->EvalPot); ?>, 
                        <?php print($coach->DevPlayers); ?>, 
                        <?php print($coach->Strategy); ?>
                        ],
                    pointPlacement: 'on'
                    }, 
                ],

            });

        </script>

        <div class="container">
            <div class="row">
                <div class="col little"><span>Eval Off {{$coach->EvalOff}}</span></div>
                <div class="col little"><span>Eval Def {{$coach->EvalDef}}</span></div>
                <div class="col little"><span>Eval Pot {{$coach->EvalPot}}</span></div>
                <div class="col little"><span>Plyr Dev {{$coach->DevPlayers}}</span></div>
                <div class="col little"><span>Strategy {{$coach->Strategy}}</span></div>
            </div>
        </div>

    </div>

    <div class="coachInfo">
        <div class="coachPhi">
            <h2>Philosophies</h2>
            <hr/>
            <div class="container">
                <div class="row">
                    <div class="col"><span>Personality</span></div>
                    <div class="col">{{$coach->PersonalityText}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Greed</span></div>
                    <div class="col">{{$coach->Greed}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Player Preference</span></div>
                    <div class="col">{{$coach->PrefPlayers}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Player Rotation</span></div>
                    <div class="col">{{$coach->PrefRotation}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Offensive Pace</span></div>
                    <div class="col">{{$coach->PrefTempo}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Crash Off. Boards</span></div>
                    <div class="col">{{$coach->PrefCrashOBoard}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Defensive Intensity</span></div>
                    <div class="col">{{$coach->PrefIntensity}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Crash Def. Boards</span></div>
                    <div class="col">{{$coach->PrefCrashDBoard}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Full Court Defense</span></div>
                    <div class="col">{{$coach->PrefFCDefense}}</div>
                    <div class="w-100"></div>
                    <div class="col"><span>Zone Defense</span></div>
                    <div class="col">{{$coach->PrefZoneDefense}}</div>
                    <div class="w-100"></div>
                </div>
            </div>
        </div>

        <div class="coachHis">
        <h2>History</h2>
        <hr/>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Season</th>
                    <th scope="col">Team</th>
                    <th scope="col">Record</th>
                    <th scope="col">Postseason</th>
                    </tr>
                </thead>
                <tbody>
                    @if(sizeof($coachHistory) > 0)
                    @foreach($coachHistory as $season)
                    <tr>
                    <th scope="row">{{$season->Season}}</th>
                    <td>{{$season->Team}}</td>
                    <td>{{$season->Wins}}-{{$season->Losses}}</td>
                    <td>{{$season->PostSeason}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="nodata" colspan="4">No data available in table</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

</section>

@endsection