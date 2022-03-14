@extends('layout')

@section('title')
Team League Leaders - {{ config('app.name') }}
@endsection

@section('description')
Líderes de {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/sortable/sortable.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')
<section class="normal">
<h1>Team League Leaders</h1>
<div class="table-responsive">
  <table class="table sortable">
    <thead class="thead">
      <tr>
        <th scope="col">TEAM</th>
        <th scope="col">PPG</th>
        <th scope="col">OPPG</th>
        <th scope="col">FG%</th>
        <th scope="col">3P%</th>
        <th scope="col">FT%</th>
        <th scope="col">APG</th>
        <th scope="col">RPG</th>
        <th scope="col">BPG</th>
        <th scope="col">SPG</th>
        <th scope="col">TOPG</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($teamCollection as $team)
          <tr>
            <td><img width="16" src="{{$team['Img']}}">
              <a href="{{ url('team', [ 'id' => $team['TeamID'] ]) }}">
              {{$team['CityName']}}</a></td>
            <td>{{$team['PPG']}}</td>
            <td>{{$team['OPPG']}}</td>
            <td>{{$team['FGPct']}}</td>
            <td>{{$team['FG3PPct']}}</td>
            <td>{{$team['FTPct']}}</td>
            <td>{{$team['APG']}}</td>
            <td>{{$team['RPG']}}</td>
            <td>{{$team['BPG']}}</td>
            <td>{{$team['SPG']}}</td>
            <td>{{$team['TOPG']}}</td>
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