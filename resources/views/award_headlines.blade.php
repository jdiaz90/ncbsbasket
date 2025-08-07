@extends('layout')

@section('title')
Awards Headlines- {{ config('app.name') }} 
@endsection

@section('description')
Premios semanales y mensuales de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">
<h1>Awards</h1>
<form role="form" method="POST">
  @csrf
  <select onchange="this.form.submit();" name="league" class="form-select Stat" aria-label="Default select league">
    <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
    <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
  </select>
</form>

<table class="table">
  <thead>
      <tr>
        <th scope="col">AWARD HEADLINES</th>
      </tr>
    </thead>
    <thead>
      <tr>
        <th scope="col"><b><i>PBL Player Of The Month Award Winners<i></b></th>
      </tr>
    </thead>
    <tbody>
  @foreach($month as $award)
      <tr>
        <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
          </svg>
          Week Ended {{ $award->days?->AwardWinnersDay ?? $award->Day }}
        </td>
      </tr>
      <tr>
        <td>
          <a href="{{url('player', [ 'id' => $award->player->PlayerID ])}}">{{$award->player->Full_Name}}</a> - 
          <a href="{{url('team', [ 'id' => $award->mainTeam->TeamID ])}}">{{$award->mainTeam->Franchise}}</a>
        </td>
      </tr>
  @endforeach
    </tbody>
    <thead>
      <tr>
        <th scope="col"><b><i>PBL Player Of The Week Award Winners<i></b></th>
      </tr>
    </thead>
    <tbody>
  @foreach($week as $award)
      <tr>
        <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
          </svg>
          Week Ended {{ $award->days?->AwardWinnersDay ?? $award->Day }}
        </td>
      </tr>
      <tr>
        <td>
          <a href="{{url('player', [ 'id' => $award->player->PlayerID ])}}">{{$award->player->Full_Name}}</a> - 
          <a href="{{url('team', [ 'id' => $award->mainTeam->TeamID ])}}">{{$award->mainTeam->Franchise}}</a></td>
      </tr>
  @endforeach
    </tbody>
    @if ($rookie->count() > 0)
    <thead>
      <tr>
        <th scope="col"><b><i>PBL Rookie Of The Month Award Winners<i></b></th>
      </tr>
    </thead>
    <tbody>
  @foreach($rookie as $award)
      <tr>
        <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zm9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5zM8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
          </svg>
          Week Ended {{ $award->days?->AwardWinnersDay ?? $award->Day }}
        </td>
      </tr>
      <tr>
        <td>
          <a href="{{url('player', [ 'id' => $award->player->PlayerID ])}}">{{$award->player->Full_Name}}</a> - 
          <a href="{{url('team', [ 'id' => $award->mainTeam->TeamID ])}}">{{$award->mainTeam->Franchise}}</a></td>
      </tr>
  @endforeach
    </tbody>
    @endif
  </table>

</section>

@endsection