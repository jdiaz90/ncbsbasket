@extends('layout')

@section('title')
Schedule - {{ config('app.name') }}
@endsection

@section('description')
Calendario de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">

<h1>Schedule</h1>
<div class="table-responsive">

  <table class="table">
    @foreach ($schedule as $day)
    <thead>
      <tr>
        <th scope="col">Date</th>
        <th scope="col">Away</th>
        <th scope="col">Home</th>
        <th scope="col">Result</th>
        <th scope="col">High Pts</th>
        <th scope="col">High Ast</th>
        <th scope="col">High Reb</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($day as $game)
      <tr>
          <td>{{$game->ShortDate}}</td>
          @if($game->HomeScore > $game->VisitorScore)
          <td>
            <img class="scheduleLogo" src="{{$game->getLogo($game->Visitor)}}">
            <a href="{{ url('team', [ 'id' => $game->getTeamID($game->Visitor) ]) }}">{{$game->Visitor}}</a>
          </td>
          <td>
            <img class="scheduleLogo" src="{{$game->getLogo($game->Home)}}">
            <a href="{{ url('team', [ 'id' => $game->getTeamID($game->Home) ]) }}"><b>{{$game->Home}}</b></a>
          </td> 
          @elseif($game->HomeScore < $game->VisitorScore)
          <td>
            <img class="scheduleLogo" src="{{$game->getLogo($game->Visitor)}}">
            <a href="{{ url('team', [ 'id' => $game->getTeamID($game->Visitor) ]) }}"><b>{{$game->Visitor}}</b></a>
          </td>
          <td>
            <a href="{{ url('team', [ 'id' => $game->getTeamID($game->Home) ]) }}">
            <img class="scheduleLogo" src="{{$game->getLogo($game->Home)}}">{{$game->Home}}</a>
          </td>
          @else
          <td>
            <img class="scheduleLogo" src="{{$game->getLogo($game->Visitor)}}">
            <a href="{{ url('team', [ 'id' => $game->getTeamID($game->Visitor) ]) }}">{{$game->Visitor}}</a>
          </td>
          <td>
            <a href="{{ url('team', [ 'id' => $game->getTeamID($game->Home) ]) }}">
            <img class="scheduleLogo" src="{{$game->getLogo($game->Home)}}">{{$game->Home}}</a>
          </td>  
          @endif
          <td><a href="{{ url('schedule/game', [ 'id' => $game->GameNo ]) }}">{{$game->VisitorScore}}-{{$game->HomeScore}}</a></td>
          <td>
            {{$highsPoints[$game->GameNo]['HPoints']}} 
            <a href="{{ url('player', [ 'id' => $highsPoints[$game->GameNo]->player->PlayerID ]) }}">{{$highsPoints[$game->GameNo]->player->AbName}}</a>
          </td>
          <td>
            {{$highsAssists[$game->GameNo]['HAssists']}} 
            <a href="{{ url('player', [ 'id' => $highsAssists[$game->GameNo]->player->PlayerID ]) }}">{{$highsAssists[$game->GameNo]->player->AbName}}</a>
          </td>
          <td>
            {{$highsRebounds[$game->GameNo]['HRebounds']}} 
            <a href="{{ url('player', [ 'id' => $highsRebounds[$game->GameNo]->player->PlayerID ]) }}">{{$highsRebounds[$game->GameNo]->player->AbName}}</a>
          </td>
          </tr>
      @endforeach
    </tbody>
    @endforeach
  </table>

</div>

</section>

@endsection
