@extends('layout')

@section('title')
Past Standings - {{ config('app.name') }}
@endsection

@section('description')
Clasificaciones anteriores de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/paststandings.js"></script>
@endsection

@section('section')

<section class="normal">
  <h1>Past Standings</h1>
  <form id="form" role="form" method="POST">
    @csrf
    <select onchange="this.form.submit();" name="year" class="form-select league PastYear" aria-label="Default select year">
      @foreach ($years as $key => $season)
        <option value="{{$season->Season}}" {{$selectedSeason[$key]}}>{{$season->Season}}</option>
      @endforeach
    </select>
    <select onchange="this.form.submit();" name="league" class="form-select league PastStandings" aria-label="Default select league">
      <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
      <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
    </select>
    <div class="btn-group standings" role="group" aria-label="Basic radio toggle button group">
      <input onchange="this.form.submit();" type="radio" class="btn-check" name="standings" value="L" id="btnradio1" autocomplete="off" {{$selectedStandings[0]}}>
      <label class="btn btn-outline-primary" for="btnradio1"><span class="long">League</span><span class="short">L</span></label>
    @if ($_POST['league'] == "D")
      <input type="radio" class="btn-check" name="standings" id="btnradio2" autocomplete="off" disabled>
      <label class="btn btn-outline-primary" for="btnradio2"> - </label>
    @else
      <input onchange="this.form.submit();" type="radio" class="btn-check" name="standings" value="C" id="btnradio2" autocomplete="off" {{$selectedStandings[1]}}>
      <label class="btn btn-outline-primary" for="btnradio2"><span class="long">Conference</span><span class="short">C</span></label>
    @endif
      <input onchange="this.form.submit();" type="radio" class="btn-check" name="standings" value="D" id="btnradio3" autocomplete="off" {{$selectedStandings[2]}}>
      <label class="btn btn-outline-primary" for="btnradio3"><span class="long">Division</span><span class="short">D</span></label>
    </div>
  </form>
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col"></th>
        <th scope="col">W</th>
        <th scope="col">L</th>
        <th scope="col">PCT</th>
        <th scope="col">GB</th>
      </tr>
    </thead>
    @foreach ($divisions as $key => $division)
    <thead>
      <tr>
        <th colspan="11">{{$key}}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($division as $name => $team)
      <tr>
        <th scope="row"><img src="{{$team['IMG']}}" width="16"> <a href={{$team['URL']}}>{{$name}}</a></th>
        <td>{{$team['W']}}</td>
        <td>{{$team['L']}}</td>
        <td>{{$team['PCT']}}</td>
        <td>{{$team['GB']}}</td>
      </tr> 
      @endforeach
    </tbody>
    @endforeach
  </table>
</section>

@endsection


