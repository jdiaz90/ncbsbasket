@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script>

  @include('js/changeURL')
  
  
  @include('js/changeURL2')

</script>   
@endsection

@section('section')

<section>

@include('html.team_top')

<div class="container teamHistory">
  <div class="row">
    <div class="col-md">
      <button type="button" onclick="changeURL2(1);" class="btn btn-secondary teamHistoryButton">Player Records</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(2);" class="btn btn-secondary teamHistoryButton disabled">Coach Records</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(3);" class="btn btn-secondary teamHistoryButton">Player History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(4);" class="btn btn-secondary teamHistoryButton">Season Recaps</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(5);" class="btn btn-secondary teamHistoryButton">Draft History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(6);" class="btn btn-secondary teamHistoryButton">Transaction History</button>
    </div>
  </div>
</div>
<h2 id="h2Staff">Coach Records</h2>
<form role="form">
<select onchange="this.form.submit();" class="form-select coachRecords" id="record" name="record" aria-label="Default select record">
  <option disabled hidden value="Select Record">Select Record</option>
  <option {{$selected[0]}}>Wins</option>
  <option {{$selected[1]}}>Losses</option>
  <option {{$selected[2]}}>Win Percentage</option>
  <option {{$selected[3]}}>Playoff Appearances</option>
  <option {{$selected[4]}}>Championships</option>
</select>
</form>

<div class="table-responsive normal">
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">RANK</th>
        <th scope="col">COACH</th>
        <th scope="col">TEAM</th>
        <th scope="col">STAT</th>
      </tr>
    </thead>
    <tbody>
      @if (count($seasonStats) == 0)
      <tr>
        <td colspan="4" class="nodata">No data available in table</td>
      </tr>
      @else
        @foreach ($seasonStats as $season)
      <tr>
        <th scope="row">{{++$c}}.</th>
        <th scope="row">{{$season->CoachName}}</th>
        <td>{{$season->team->Franchise}}</td>
        @if($stat == 'Win Percentage')
        <td>{{round($season->Stat * 100, 1)}}</td>
        @else
        <td>{{$season->Stat}}</td>
        @endif
      </tr>
        @endforeach 
      @endif 
    </tbody>
  </table>
</div>

<script>

  $('table.table').stickyTableHeaders();

</script>


</section>

@endsection


