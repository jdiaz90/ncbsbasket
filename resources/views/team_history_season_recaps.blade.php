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
      <button type="button" onclick="changeURL2(2);" class="btn btn-secondary teamHistoryButton">Coach Records</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(3);" class="btn btn-secondary teamHistoryButton">Player History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(4);" class="btn btn-secondary teamHistoryButton disabled">Season Recaps</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(5);" class="btn btn-secondary teamHistoryButton">Draft History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(6);" class="btn btn-secondary teamHistoryButton">Transaction History</button>
    </div>
  </div>
</div>

<div class="table-responsive normal">
  <h2 id="h2Staff">Season Recaps</h2>
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">SEASON</th>
        <th scope="col">COACH</th>
        <th scope="col">RECORD</th>
        <th scope="col">POSTSEASON</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($recaps as $season)
      <tr>
        <th scope="row">{{$season->Season}}</th>
        <th scope="row">{{$season->CoachName}}</th>
        <td>{{$season->Wins}}-{{$season->Losses}}</td>
        <td>{{$season->PostSeason}}</td>
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
