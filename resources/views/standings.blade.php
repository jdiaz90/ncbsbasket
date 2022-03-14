@extends('layout')

@section('title')
Standings - {{ config('app.name') }}
@endsection

@section('description')
Clasificación de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/standings.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')

<section class="normal">
  <h1>Standings</h1>
  <form id="form" role="form" method="POST">
    @csrf
    <select onchange="changeLeague(this.value)" name="league" class="form-select league Standings" aria-label="Default select league">
      <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
      <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
    </select>
    <div class="btn-group standings" role="group" aria-label="Basic radio toggle button group">
      <input onchange="this.form.submit();" type="radio" class="btn-check" name="standings" value="L" id="btnradio1" autocomplete="off" {{$selectedStandings[0]}}>
      <label class="btn btn-outline-primary" for="btnradio1"><span class="long">League</span><span class="short">L</span></label>
    @if (Route::currentRouteName() == "dstandings.index" || Route::currentRouteName() == "dstandings.store")
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
  
  <div class="table-responsive">
    <table class="table">
      <thead class="thead">
        <tr>
          <th scope="col"></th>
          <th scope="col">W</th>
          <th scope="col">L</th>
          <th scope="col">PCT</th>
          <th scope="col">GB</th>
          <th scope="col">CONF</th>
          <th scope="col">DIV</th>
          <th scope="col">HOME</th>
          <th scope="col">AWAY</th>
          <th scope="col">L10</th>
          <th scope="col">STREAK</th>
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
          <td>{{$team['CONF']}}</td>
          <td>{{$team['DIV']}}</td>
          <td>{{$team['HOME']}}</td>
          <td>{{$team['AWAY']}}</td>
          <td>{{$team['L10']}}</td>
          <td>{{$team['STREAK']}}</td>
        </tr> 
        @endforeach
      </tbody>
      @endforeach
    </table>
  </div>

  <script>
    $('table.table').stickyTableHeaders();
  </script>
</section>

@endsection


