@extends('layout')

@section('title')
Coach Records - {{ config('app.name') }}
@endsection

@section('description')
Records de los entrenadores de{{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')
<section class="normal">
<h1>Coach Records</h1>
<form role="form" method="POST">
  @csrf
<select onchange="this.form.submit();" class="form-select" id="record" name="record" aria-label="Default select record">
  <option disabled hidden value="Select Record">Select Record</option>
  <option {{$selected[0]}}>Wins</option>
  <option {{$selected[1]}}>Losses</option>
  <option {{$selected[2]}}>Win Percentage</option>
  <option {{$selected[3]}}>Playoff Appearances</option>
  <option {{$selected[4]}}>Championships</option>
</select>
</form>

<div class="table-responsive">
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
        @foreach ($coachHistory as $season)
      <tr>
        <th scope="row">{{++$c}}.</th>
        <th scope="row"><a href="{{ url('coach', [ 'id' => $season->CoachID ]) }}">{{$season->CoachName}}</a></th>
        <td>{{$season->team->Franchise}}</td>
        @if($stat == 'Win Percentage')
        <td>{{round($season->Stat * 100, 1)}}</td>
        @else
        <td>{{$season->Stat}}</td>
        @endif
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


