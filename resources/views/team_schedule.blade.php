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

</script>   
@endsection

@section('section')

<section>

@include('html.team_top')
<h2 id="h2Staff">Team Schedule</h2>
<div class="table-responsive normal">

  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Opponent</th>
        <th scope="col">Result</th>
        <th scope="col">W-L</th>
        <th scope="col">High Pts</th>
        <th scope="col">High Ast</th>
        <th scope="col">High Reb</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($schedule as $game)
      <tr>
          <td>{{$game->Day}}</td>
          <td>
            <img width="16" src="{{$game->getLogo($opponents[$game->GameNo]['Name'])}}">
            {{$opponents[$game->GameNo]['Home']}}
            <a href="/team/{{$opponents[$game->GameNo]['Id']}}">{{$opponents[$game->GameNo]['Name']}}</a>
          </td>
          <td>
            <a href="{{ url('schedule/game', [ 'id' => $game->GameNo ]) }}">
            {{$results[$game->GameNo]}}</a>
          </td>
          <td>{{$records[$game->GameNo]}}</td>
          <td>
            <a href="{{ url('player', [ 'id' => $abNamesPoints[$game->GameNo]['Id'] ]) }}">
            {{$abNamesPoints[$game->GameNo]['Name']}}</a> {{$highsPoints[$game->GameNo]}}
          </td>
          <td>
            <a href="{{ url('player', [ 'id' => $abNamesAssists[$game->GameNo]['Id'] ]) }}">
            {{$abNamesAssists[$game->GameNo]['Name']}}</a> {{$highsAssists[$game->GameNo]}}
          </td>
          <td>
            <a href="{{ url('player', [ 'id' => $abNamesRebounds[$game->GameNo]['Id'] ]) }}">
            {{$abNamesRebounds[$game->GameNo]['Name']}}</a> {{$highsRebounds[$game->GameNo]}}
          </td>
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
