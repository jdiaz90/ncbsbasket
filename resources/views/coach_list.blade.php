@extends('layout')

@section('title')
Coach search - {{ config('app.name') }}
@endsection

@section('description')
Todos los entrenadores de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="/js/sortable/sortable.js"></script>
@endsection

@section('section')

<section class="normal">
  <h1>Coach List</h1>

<div class="table-responsive">
  <table class="table sortable">
    <thead class="thead">
        <tr>
        <th scope="col">NAME</th>
        <th scope="col">TEAM</th>
        <th scope="col">AGE</th>
        <th scope="col">EVAL OFF</th>
        <th scope="col">EVAL DEF</th>
        <th scope="col">EVAL POT</th>
        <th scope="col">PLAYER DEV</th>
        <th scope="col">STRATEGY</th>
        <th scope="col">PACE</th>
        <th scope="col">PRESSURE</th>
        <th scope="col">LEVEL</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($coaches as $coach)
      <tr>
        <th scope="row"><a href="{{ url('coach', [ 'id' => $coach->CoachID ]) }}">{{$coach->Full_Name}}</a></td>
        @if($coach->TeamID > 0)
        <td><a href="{{ url('team', [ 'id' => $coach->TeamID ]) }}">{{$coach->coachTeam->Franchise}}</a></td>
        @else
        <td>FA</td>   
        @endif 
        <td>{{$coach->CoachAge}}</td>
        <td>{{$coach->EvalOff}}</td>
        <td>{{$coach->EvalDef}}</td>
        <td>{{$coach->EvalPot}}</td>
        <td>{{$coach->DevPlayers}}</td>
        <td>{{$coach->Strategy}}</td>
        <td data-sort="{{$coach->PrefTempoOrder}}">{{$coach->PrefTempoList}}</td>
        <td data-sort="{{$coach->PrefIntensityOrder}}">{{$coach->PrefIntensityList}}</td>
        <td>{{$coach->Level}}</td>
      </tr>
        @endforeach
    </tbody>
  </table>
</div>

<script>

    $('table.table.sortable').stickyTableHeaders();

</script>

</section>

@endsection
