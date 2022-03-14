@extends('layout')

@section('title')
Player Records - {{ config('app.name') }}
@endsection

@section('description')
Records de los jugadores de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')
<section class="normal">
<h1>Player Records</h1>
<form role="form" method="POST">
  @csrf
<select onchange="this.form.submit();" class="form-select" id="record" name="record" aria-label="Default select record">
  <option disabled hidden value="Select Record">Select Record</option>
  <option value="FGM" {{$selected[0]}}>Field Goals Made</option>
  <option value="FGA" {{$selected[1]}}>Field Goal Attempts</option>
  <option value="FTM" {{$selected[2]}}>Free Throws Made</option>
  <option value="FTA" {{$selected[3]}}>Free Throw Attempts</option>
  <option value="FG3PM" {{$selected[4]}}>3 Pointers Made</option>
  <option value="FG3PA" {{$selected[5]}}>3 Point Attempts</option>
  <option value="FGPct" {{$selected[6]}}>Field Goal Pct.</option>
  <option value="FTPct" {{$selected[7]}}>Free Throw Pct.</option>
  <option value="FG3PPct" {{$selected[8]}}>3 Point Pct.</option>
  <option value="Points" {{$selected[9]}}>Points</option>
  <option value="Assists" {{$selected[10]}}>Assists</option>
  <option value="ORebs+DRebs" {{$selected[11]}}>Rebounds</option>
  <option value="Steals" {{$selected[12]}}>Steals</option>
  <option value="Blocks" {{$selected[13]}}>Blocks</option>
  <option value="DoubleDoubles" {{$selected[14]}}>Double Doubles</option>
  <option value="TripleDoubles" {{$selected[15]}}>Triple Doubles</option>
  <option value="G" {{$selected[16]}}>Games</option>
</select>

<select onchange="this.form.submit();" class="form-select" id="period" name="period" aria-label="Default select period">
  <option value="1" {{$selected2[0]}}>Single Season</option>
  <option value="2" {{$selected2[1]}}>Career</option>
</select>
</form>

<div class="table-responsive">
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">RANK</th>
        <th scope="col">PLAYER</th>
        <th scope="col">STAT</th>
        <th scope="col">YEAR</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($seasonStats as $season)
      <tr>
        <th scope="row">{{++$c}}.</th>
        <th scope="row"><a href="{{ url('formerplayer', [ 'id' => $season->PlayerID ]) }}">{{$season->PlayerName}}</a></th>
        @if($stat == 'FGPct' ||
            $stat == 'FTPct' ||
            $stat == 'FG3PPct')
        <td>{{round($season->Stat * 100, 1)}}</td>
        @else
        <td>{{$season->Stat}}</td>
        @endif
        <td>{{$season->Season}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script>

  $('table.table').stickyTableHeaders();

</script>

</section>

@endsection


