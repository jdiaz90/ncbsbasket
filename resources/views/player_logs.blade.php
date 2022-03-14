@extends('layout')

@include('html.player_top')

<div class="container mr-2" role="group" aria-label="Player Options">
    <div class="row">
      <div class="col-md">
        <button type="button" onclick="changeURL(1);" class="btn btn-secondary">Player Bio</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(2);" class="btn btn-secondary">Player Profile</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(3);" class="btn btn-secondary">Player Stats</button>
      </div>
      <div class="col-md">
        <button type="button" class="btn btn-secondary active disabled">Game Logs</button>
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

@if(sizeof($player->Logs) > 0)
    <h2>Game Logs</h2>
    <hr/>
    <div class="overflow-auto">

        <table class="table oneline">
            <thead class="thead">
                <tr>
                    <th scope="col">Team</th>
                    <th scope="col">Date</th>
                    <th scope="col">Opponent</th>
                    <th scope="col">Start</th>
                    <th scope="col">MIN</th>
                    <th scope="col">FGM</th>
                    <th scope="col">FGA</th>
                    <th scope="col">3PM</th>
                    <th scope="col">3PA</th>
                    <th scope="col">FTM</th>
                    <th scope="col">FTA</th>
                    <th scope="col">ORB</th>
                    <th scope="col">DRB</th>
                    <th scope="col">REB</th>
                    <th scope="col">AST</th>
                    <th scope="col">PF</th>
                    <th scope="col">STL</th>
                    <th scope="col">TOV</th>
                    <th scope="col">BLK</th>
                    <th scope="col">PTS</th>
                    <th scope="col">+/-</th>
                </tr>
            </thead>
            <tbody>   

        @foreach($player->Logs as $log)
            <tr>
                @if ($log->TeamForThatDay <> null)
                <td>{{$log->TeamForThatDay['TeamName']}}</td>
                @else
                <td>{{$player->team->TeamName}}</td>  
                @endif
                <td>{{$log->schedule->Day}}</td>
                <td>{{$log->Opponent()}}</td>
                <td>{!! $log->Starter() !!}</td>
                <td>{{round($log->Minutes, 0)}}</td>
                <td>{{$log->FGM}}</td>
                <td>{{$log->FGA}}</td>
                <td>{{$log->FG3PA}}</td>
                <td>{{$log->FG3PM}}</td>
                <td>{{$log->FTM}}</td>
                <td>{{$log->FTA}}</td>
                <td>{{$log->ORebs}}</td>
                <td>{{$log->DRebs}}</td>
                <td>{{$log->Rebounds}}</td>
                <td>{{$log->Assists}}</td>
                <td>{{$log->Fouls}}</td>
                <td>{{$log->Steals}}</td>
                <td>{{$log->Turnovers}}</td>
                <td>{{$log->Blocks}}</td>
                <td>{{$log->Points}}</td>
                <td>{{$log->PlusMinus}}</td>
            </tr>
        @endforeach
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