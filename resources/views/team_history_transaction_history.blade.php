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
      <button type="button" onclick="changeURL2(4);" class="btn btn-secondary teamHistoryButton">Season Recaps</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(5);" class="btn btn-secondary teamHistoryButton">Draft History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(6);" class="btn btn-secondary teamHistoryButton disabled">Transaction History</button>
    </div>
  </div>
</div>
<h2 id="h2Staff">Transaction History</h2>
<div class="table-responsive normal">
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">PLAYER</th>
        <th scope="col">TRANSACTION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($team->transactions as $season)
      <tr>
        @if ($season->PlayerID <> 0)
        <th scope="row"><a href="{{ url('formerplayer', [ 'id' => $season->PlayerID ]) }}">{{$season->PlayerName}}</a></th>
        @else
        <th scope="row"></th>
        @endif
        <td>{{$season->Transaction}}</td>
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
